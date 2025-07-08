<?php

declare(strict_types=1);

namespace App\Http\Controllers\WEB\v1;

use Illuminate\Support\Str;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Web\ContentFooterPublicResource;
use App\Http\Resources\v1\Web\ContentHeaderPublicResource;
use App\Http\Resources\v1\Web\ContentSocialNetworkPublicResource;
use App\Http\Resources\v1\Web\GeneralInformationPublicResource;
use App\Http\Resources\v1\Web\PostPublicResource;
use App\Models\ContentFooter;
use App\Models\ContentFooterMenu;
use App\Models\ContentHeader;
use App\Models\ContentHeaderMenu;
use App\Models\ContentSocialNetwork;
use App\Models\GeneralInformation;
use App\Models\Page;
use App\Models\Post;
use App\Utils\PathHierarchy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LayoutController extends Controller
{
    /**
     * Get data header
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function getDataHeader(Request $request): JsonResponse
    {
        $general_information = GeneralInformation::first();
        $headers = ContentHeader::where('active', true)->orderBy('id', 'ASC')->get();

        return ApiResponse::createResponse()
            ->withData([
                'general_information' => new GeneralInformationPublicResource($general_information),
                'headers' => ContentHeaderPublicResource::collection($headers),
            ])
            ->build();
    }

    /**
     * Get data footer
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getDataFooter(Request $request): JsonResponse
    {
        $content_social_network = ContentSocialNetwork::with(['masterSocialNetworkRel'])->where('active', true)->get();
        $footers = ContentFooter::where('active', true)->orderBy('id', 'ASC')->get();

        return ApiResponse::createResponse()
            ->withData([
                'content_social_network' => ContentSocialNetworkPublicResource::collection($content_social_network),
                'footers' => ContentFooterPublicResource::collection($footers),
            ])
            ->build();
    }

    public function showHierarchy(Request $request)
    {
        $search = $request->query('q', null);

        $param_with = [
            'childMenus' => function ($q1) use ($search) {
                if ($search) {
                    $q1->where('name', 'LIKE', "%{$search}%");
                }
                $q1->orderBy('index', 'ASC')
                    ->with([
                        'childMenus' => function ($q2) use ($search) {
                            if ($search) {
                                $q2->where('name', 'LIKE', "%{$search}%");
                            }
                            $q2->orderBy('index', 'ASC')
                                ->with([
                                    'childMenus' => function ($q3) use ($search) {
                                        if ($search) {
                                            $q3->where('name', 'LIKE', "%{$search}%");
                                        }
                                        $q3->orderBy('index', 'ASC');
                                    }
                                ]);
                        }
                    ]);
            }
        ];

        if ($search) {
            $contentHeaderMenus = ContentHeaderMenu::where('name', 'LIKE', "%{$search}%")
                ->whereNull('content_header_menu_id')
                ->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        // Nivel 1 de hijos
                        ->orWhereHas('childMenus', function ($q1) use ($search) {
                            $q1->where('name', 'LIKE', "%{$search}%")
                                // Nivel 2
                                ->orWhereHas('childMenus', function ($q2) use ($search) {
                                    $q2->where('name', 'LIKE', "%{$search}%")
                                        // Nivel 3
                                        ->orWhereHas('childMenus', function ($q3) use ($search) {
                                            $q3->where('name', 'LIKE', "%{$search}%");
                                        });
                                });
                        });
                })
                ->with($param_with)
                ->orderBy('index', 'ASC')
                ->get();

            $contentFooterMenus = ContentFooterMenu::where('name', 'LIKE', "%{$search}%")
                ->whereNull('content_footer_menu_id')
                ->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        // Nivel 1 de hijos
                        ->orWhereHas('childMenus', function ($q1) use ($search) {
                            $q1->where('name', 'LIKE', "%{$search}%")
                                // Nivel 2
                                ->orWhereHas('childMenus', function ($q2) use ($search) {
                                    $q2->where('name', 'LIKE', "%{$search}%")
                                        // Nivel 3
                                        ->orWhereHas('childMenus', function ($q3) use ($search) {
                                            $q3->where('name', 'LIKE', "%{$search}%");
                                        });
                                });
                        });
                })
                ->with($param_with)
                ->orderBy('index', 'ASC')
                ->get();

            $posts = Post::where('title', 'LIKE', "%{$search}%")->where('active', true)
                ->orWhere('short_description', 'LIKE', "%{$search}%")
                ->get();
        } else {
            // Sin filtro
            $contentHeaderMenus = ContentHeaderMenu::whereNull('content_header_menu_id')
                ->with($param_with)
                ->orderBy('index', 'ASC')
                ->get();

            $contentFooterMenus = ContentFooterMenu::whereNull('content_footer_menu_id')
                ->with($param_with)
                ->orderBy('index', 'ASC')
                ->get();

            $posts = collect();
        }

        // Construimos la jerarquía con tu clase
        $hierarchy = new PathHierarchy();

        // 1) Recorrer los menús raíz y sus hijos de manera recursiva
        foreach ($contentHeaderMenus as $menu) {
            $this->addMenuToHierarchy($menu, $hierarchy, '', "headers");
        }

        // 2) Recorrer los menús raíz y sus hijos de manera recursiva
        foreach ($contentFooterMenus as $menu) {
            $this->addMenuToHierarchy($menu, $hierarchy, '', "footers");
        }

        // 3) Añadir POSTS como un path (opcional), por ejemplo "blog-posts/{slug}"
        foreach ($posts as $post) {
            $path  = $post->slug;
            $name  = $post->title;
            $extras = [
                '_pagePath'      => $path,
                '_type_page'     => 'posts',
            ];
            $hierarchy->addPath($path, $name, $extras);
        }

        // Obtenemos el árbol final
        $tree = $hierarchy->getTree();

        return ApiResponse::createResponse()
            ->withData(['pages' => $tree])
            ->build();
    }

    /**
     * Función recursiva para “inyectar” un menú y todos sus hijos en la PathHierarchy.
     *
     * @param $menu        El menú actual
     * @param PathHierarchy     $hierarchy   El objeto que construye el árbol
     * @param string            $prefix      Prefijo de path acumulado
     */
    private function addMenuToHierarchy($menu, PathHierarchy $hierarchy, string $prefix = '', $type_page)
    {
        // Generar un "segment" único, por ejemplo, slug del nombre (o podrías usar el ID)
        $segment = Str::slug($menu->name); // "menu-1", "menu-23", etc.
        // Construir el path acumulado: "prefix/segment"
        $path = trim($prefix . '/' . $segment, '/'); // p.ej. "menu-1/menu-22"

        // Extras que quieras añadir
        $extras = [
            '_pagePath'      => $menu->content_menu_type_id === 4 ? $menu->content : "",
            '_type_page'     => $type_page
        ];

        // Añadimos este menú como “nodo” en PathHierarchy
        $hierarchy->addPath($path, $menu->name, $extras);

        // Recorrer sus hijos y recursar
        foreach ($menu->childMenus as $child) {
            $this->addMenuToHierarchy($child, $hierarchy, $path, $type_page);
        }
    }
}
