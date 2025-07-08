<?php

namespace App\Http\Controllers\API\v1\Helpers;

use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller as Controller;
use App\Http\Resources\v1\AttributeTypeResource;
use App\Http\Resources\v1\CategoryResource;
use App\Http\Resources\v1\ContentMasterSocialNetworkResource;
use App\Http\Resources\v1\ContentMenuTypeResource;
use App\Http\Resources\v1\EmploymentAreaResource;
use App\Http\Resources\v1\EmploymentResource;
use App\Http\Resources\v1\EmploymentTypeResource;
use App\Http\Resources\v1\ModuleResource;
use App\Http\Resources\v1\PageFieldTypeResource;
use App\Http\Resources\v1\PageMultipleFieldResource;
use App\Http\Resources\v1\PageResource;
use App\Http\Resources\v1\PageSectionResource;
use App\Http\Resources\v1\PostResource;
use App\Http\Resources\v1\Web\SustainabilityReportPublicResource;
use App\Http\Resources\v1\TagResource;
use App\Http\Resources\v1\TypeMapResource;
use App\Http\Resources\v1\Web\MapPublicResource;
use App\Models\AttributeType;
use App\Models\Category;
use App\Models\ContentMasterSocialNetwork;
use App\Models\ContentMenuType;
use App\Models\Employment;
use App\Models\EmploymentArea;
use App\Models\EmploymentType;
use App\Models\Map;
use App\Models\MasterUbigeo;
use App\Models\Module;
use App\Models\Page;
use App\Models\PageFieldType;
use App\Models\PageMultipleField;
use App\Models\PageSection;
use App\Models\Post;
use App\Models\SustainabilityReport;
use App\Models\Tag;
use App\Models\TypeMap;
use App\Traits\AttributeTrait;
use App\Traits\ModulesTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class CmsController extends Controller
{
    use ModulesTrait, AttributeTrait;

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParamsCreateUser(Request $request): JsonResponse
    {
        $roles = Role::select('id', 'name')->where('guard_name', 'web');
        if (!auth()->user()->hasRole('Superadministrador')) {
            $roles = $roles->where('name', '<>', 'Superadministrador');
        }

        $roles = $roles->get();

        $data_retornar = [
            'roles' => $roles
        ];
        return ApiResponse::createResponse()
            ->withData($data_retornar)
            ->build();
    }

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPermissionCreateRole(Request $request): JsonResponse
    {
        $modules = Module::where('name', '<>', 'Dashboard')->where('active', true)->orderby('index', 'asc')->get();

        $permissions = Permission::get();

        $array_resources = array(
            array('id' => 'module', 'name' => 'Permiso')
        );
        $array_resources = array_merge($array_resources, $this->operationForPermissions());

        $permissions_process = array();

        foreach ($modules as $keyModule => $module) {
            if (!$module->module_id) {
                $array_submodules = array();
                $has_submodules = false;

                foreach ($modules as $keySubmodule => $valueSubmodule) {
                    if ($valueSubmodule->module_id == $module->id) {
                        $has_submodules = true;
                        array_push($array_submodules, $valueSubmodule);
                    }
                }

                $permission_submodules = array();
                if ($has_submodules) {
                    foreach ($array_submodules as $keySubmodule => $valueSubmodule) {
                        $resource =  $this->processResoucesForPermission($array_resources, $permissions, $valueSubmodule);
                        array_push(
                            $permission_submodules,
                            [
                                'name' => $valueSubmodule->name,
                                'resource' => $resource
                            ]
                        );
                    }
                } else {
                    $resource =  $this->processResoucesForPermission($array_resources, $permissions, $module);
                    array_push(
                        $permission_submodules,
                        [
                            'name' => $module->name,
                            'resource' => $resource
                        ]
                    );
                }

                array_push(
                    $permissions_process,
                    [
                        'name' => $module->name,
                        'submodules' => $permission_submodules
                    ]
                );
            }
        }

        $data_retornar = [
            'headers' => $array_resources,
            'permissions' => $permissions_process
        ];
        return ApiResponse::createResponse()
            ->withData($data_retornar)
            ->build();
    }

    public function processResoucesForPermission($array_resources, $permissions, $module)
    {
        $resource = array();
        foreach (array_slice($array_resources, 1) as $keyreso => $valuereso) {
            $validate_permission = false;
            $per = (object) [];
            foreach ($permissions as $key => $permission) {
                if ($permission->module_id == $module->id && $valuereso['name'] == $permission->description) {
                    $validate_permission = true;
                    $per = $permission;
                    break;
                }
            }
            array_push($resource, [
                'id' => $validate_permission ?  $per->id : "",
                'name' =>  $validate_permission ? $per->name : "",
                'description' => $validate_permission ? $per->description : ""
            ]);
        }
        return $resource;
    }

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParamsCreateModules(Request $request): JsonResponse
    {
        $data_retornar = [
            'order_directions' => $this->orderDirections()
        ];

        return ApiResponse::createResponse()
            ->withData($data_retornar)
            ->build();
    }

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParamsCreateSubmodules(Request $request): JsonResponse
    {
        $data_retornar = [
            'order_directions' => $this->orderDirections()
        ];

        return ApiResponse::createResponse()
            ->withData($data_retornar)
            ->build();
    }

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParamsCreatePermissions(Request $request): JsonResponse
    {
        $modules = Module::orderBy('index', 'ASC')->get();

        $data_retornar = [
            'operations' => $this->operationForPermissions(),
            'modules' => ModuleResource::collection($modules)

        ];

        return ApiResponse::createResponse()
            ->withData($data_retornar)
            ->build();
    }

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParamsCreateAttributes(Request $request): JsonResponse
    {
        $attribute_types = AttributeType::where('active', 1)->get();

        $data_retornar = [
            'models' => $this->models(),
            'lookup_models' => $this->lookupModels(),
            'attribute_types' => AttributeTypeResource::collection($attribute_types)
        ];

        return ApiResponse::createResponse()
            ->withData($data_retornar)
            ->build();
    }

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParamsCreateField(Request $request): JsonResponse
    {
        $types = PageFieldType::get();

        $data_retornar = [
            'types' => PageFieldTypeResource::collection($types)

        ];

        return ApiResponse::createResponse()
            ->withData($data_retornar)
            ->build();
    }

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParamsCreateMultipleFieldSection(Request $request): JsonResponse
    {
        $multiple_fields = PageMultipleField::get();

        $data_retornar = [
            'multiple_fields' => PageMultipleFieldResource::collection($multiple_fields)

        ];

        return ApiResponse::createResponse()
            ->withData($data_retornar)
            ->build();
    }

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParamsCreateContentSocialNetwork(Request $request): JsonResponse
    {
        $content_master_social_networks = ContentMasterSocialNetwork::get();

        $data_retornar = [
            'content_master_social_networks' => ContentMasterSocialNetworkResource::collection($content_master_social_networks)

        ];

        return ApiResponse::createResponse()
            ->withData($data_retornar)
            ->build();
    }

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function getParamsTagsCreatePost(Request $request): JsonResource
    {
        $q = $request->q;

        $elements = new Tag();

        if ($q) {
            $elements = $elements->where(function ($query) use ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
                $query->orWhere('slug', 'LIKE', '%' . $q . '%');
            });
        }

        $elements = $elements->orderBy('created_at', 'DESC')->paginate(15);

        return TagResource::collection($elements);
    }

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function getParamsCategoriesCreatePost(Request $request): JsonResource
    {
        $q = $request->q;

        $elements = new Category();

        if ($q) {
            $elements = $elements->where(function ($query) use ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
                $query->orWhere('slug', 'LIKE', '%' . $q . '%');
            });
        }

        $elements = $elements->orderBy('created_at', 'DESC')->paginate(50);

        return CategoryResource::collection($elements);
    }

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function getParamsPostsCreatePost(Request $request): JsonResource
    {
        $q = $request->q;

        $elements = new Post();

        if ($q) {
            $elements = $elements->where(function ($query) use ($q) {
                $query->where('title', 'LIKE', '%' . $q . '%');
                $query->orWhere('short_description', 'LIKE', '%' . $q . '%');
            });
        }

        $elements = $elements->orderBy('created_at', 'DESC')->paginate(15);

        return PostResource::collection($elements);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDepartments(): JsonResponse
    {
        $data_retornar = MasterUbigeo::select('code_department', 'department')->distinct()->orderBy('department')->get();

        return ApiResponse::createResponse()
            ->withData($data_retornar)
            ->build();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProvinces($department): JsonResponse
    {
        $data_retornar = MasterUbigeo::select('code_province', 'province')->distinct()->where('code_department', $department)
            ->where('code_province', '!=', '00')->orderBy('province')->get();

        return ApiResponse::createResponse()
            ->withData($data_retornar)
            ->build();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDistricts($department, $province): JsonResponse
    {
        $data_retornar = MasterUbigeo::select('code_district', 'district')->distinct()->where('code_department', $department)
            ->where('code_province', $province)
            ->where('code_district', '!=', '00')->orderBy('district')->get();

        return ApiResponse::createResponse()
            ->withData($data_retornar)
            ->build();
    }

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function getParamsAreasCreateEmployment(Request $request): JsonResource
    {
        $q = $request->q;

        $elements = new EmploymentArea();

        if ($q) {
            $elements = $elements->where(function ($query) use ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
            });
        }

        $elements = $elements->orderBy('created_at', 'DESC')->paginate(15);

        return EmploymentAreaResource::collection($elements);
    }

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function getParamsTypesCreateEmployment(Request $request): JsonResource
    {
        $q = $request->q;

        $elements = new EmploymentType();

        if ($q) {
            $elements = $elements->where(function ($query) use ($q) {
                $query->where('name', 'LIKE', '%' . $q . '%');
            });
        }

        $elements = $elements->orderBy('created_at', 'DESC')->paginate(15);

        return EmploymentTypeResource::collection($elements);
    }

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function getParamsEmploymentCreateEmployment(Request $request): JsonResource
    {
        $q = $request->q;

        $elements = new Employment();

        if ($q) {
            $elements = $elements->where(function ($query) use ($q) {
                $query->where('title', 'LIKE', '%' . $q . '%');
                $query->orWhere('description', 'LIKE', '%' . $q . '%');
            });
        }

        $elements = $elements->orderBy('created_at', 'DESC')->paginate(15);

        return EmploymentResource::collection($elements);
    }

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function getParamsMenuType(Request $request): JsonResource
    {
        $elements = ContentMenuType::orderBy('id', 'ASC')->get();

        return ContentMenuTypeResource::collection($elements);
    }

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function getDataPage(Request $request, Page $page): JsonResource
    {
        return new PageResource($page);
    }

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function getDataPageSection(Request $request, PageSection $pageSection): JsonResource
    {
        return new PageSectionResource($pageSection);
    }

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function getSustainabilityReport(Request $request): JsonResource
    {
        $elements = SustainabilityReport::with('reportObjectsRels')->orderBy('index', 'ASC')->get();

        return SustainabilityReportPublicResource::collection($elements);
    }

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getParamsCreateMap(Request $request): JsonResponse
    {
        $type_map = TypeMap::where('id', '<>', 4)->get();

        $data_retornar = [
            'type_map' => TypeMapResource::collection($type_map)
        ];

        return ApiResponse::createResponse()
            ->withData($data_retornar)
            ->build();
    }

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function getMapDistributor(Request $request): JsonResource
    {
        $code_department = $request->code_department;
        $code_province = $request->code_province;
        $code_district = $request->code_district;
        $per_page =  $request->per_page ?  $request->per_page : 10;

        $elements = Map::where('type_map_id', 4)->where('active', 1);

        if ($code_department) {
            $elements = $elements->where(function ($query) use ($code_department) {
                $query->where('code_department', $code_department);
            });
        }

        if ($code_province) {
            $elements = $elements->where(function ($query) use ($code_province) {
                $query->where('code_province', $code_province);
            });
        }

        if ($code_district) {
            $elements = $elements->where(function ($query) use ($code_district) {
                $query->where('code_district', $code_district);
            });
        }

        if ($request->sort_by) {
            $elements = $elements->orderBy($request->sort_by, $request->descending ? $request->descending : 'ASC')->paginate((int) $per_page);
        } else {
            $elements = $elements->paginate((int) $per_page);
        }

        return MapPublicResource::collection($elements);
    }

    /**
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function getMapServiceStation(Request $request): JsonResource
    {
        $code_department = $request->code_department;
        $code_province = $request->code_province;
        $code_district = $request->code_district;
        $type_map = $request->type_map; //multiple 1,2
        $per_page =  $request->per_page ?  $request->per_page : 10;

        $elements = Map::where('type_map_id', '<>', 4)->where('active', 1);

        if ($code_department) {
            $elements = $elements->where(function ($query) use ($code_department) {
                $query->where('code_department', $code_department);
            });
        }

        if ($code_province) {
            $elements = $elements->where(function ($query) use ($code_province) {
                $query->where('code_province', $code_province);
            });
        }

        if ($code_district) {
            $elements = $elements->where(function ($query) use ($code_district) {
                $query->where('code_district', $code_district);
            });
        }

        if ($type_map) {
            $elements = $elements->where(function ($query) use ($type_map) {
                $query->whereIn('type_map_id', explode(',', $type_map));
            });
        }

        if ($request->sort_by) {
            $elements = $elements->orderBy($request->sort_by, $request->descending ? $request->descending : 'ASC')->paginate((int) $per_page);
        } else {
            $elements = $elements->paginate((int) $per_page);
        }

        return MapPublicResource::collection($elements);
    }
}
