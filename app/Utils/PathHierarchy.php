<?php

namespace App\Utils;

class PathHierarchy
{
    /**
     * Aquí guardamos la raíz del árbol como un array.
     * Cada elemento tendrá esta forma:
     * [
     *   'segment'    => 'algo',
     *   '_pageName'  => '...',
     *   '_pagePath'  => '...',
     *   '_children'  => [...],
     *   // etc.
     * ]
     */
    protected array $tree = [];

    /**
     * Añade un path al árbol y, opcionalmente, un nombre y extras adicionales.
     *
     * @param  string       $path      ruta (puede ser algo virtual, tipo "menu-1/menu-122")
     * @param  string|null  $pageName  nombre a mostrar en el último nodo
     * @param  array        $extras    valores adicionales para guardar en el último nodo
     * @return void
     */
    public function addPath(string $path, ?string $pageName = null, array $extras = []): void
    {
        // Si el path está vacío (ej. ""), podrías manejarlo para que no cree un nodo "vacío".
        // Por ejemplo, si un menú raíz no tiene "path", puedes crear un "segment" único según su ID o slug,
        // o simplemente retornar sin hacer nada. Depende de tu lógica.
        if (! $path) {
            // Puedes manejarlo de forma particular, o ignorarlo.
            // Por ejemplo, para un "menú raíz", podrías hacer:
            // $path = 'root-' . uniqid();
            // O bien, si no quieres nodos vacíos, haz return.
            return;
        }

        // Dividir en segmentos (p.ej. "menu-1/menu-22" => ["menu-1", "menu-22"])
        $segments = explode('/', trim($path, '/'));
        $numSegments = count($segments);

        // Apuntamos al array raíz para ir descendiendo
        $currentChildren = &$this->tree;

        // Recorremos cada segmento
        foreach ($segments as $index => $seg) {
            // 1) Buscar si ya existe un hijo con 'segment' = $seg
            $foundKey = null;
            foreach ($currentChildren as $key => $child) {
                if (isset($child['segment']) && $child['segment'] === $seg) {
                    $foundKey = $key;
                    break;
                }
            }

            // 2) Si no existe, lo creamos
            if ($foundKey === null) {
                $newChild = [
                    'segment'   => $seg,
                    '_children' => [],
                ];
                $currentChildren[] = $newChild;
                // El "foundKey" será la posición recién agregada
                $foundKey = array_key_last($currentChildren);
            }

            // 3) Si estamos en el último segmento, añadimos info
            if ($index === $numSegments - 1) {
                // `_pageName`
                if ($pageName) {
                    $currentChildren[$foundKey]['_pageName'] = $pageName;
                }

                // Mezclamos extras (ej. _content, _content_format, etc.)
                foreach ($extras as $k => $val) {
                    $currentChildren[$foundKey][$k] = $val;
                }

                // No bajamos más (estamos en el último segmento)
            } else {
                // 4) Bajamos al siguiente nivel
                $currentChildren = &$currentChildren[$foundKey]['_children'];
            }
        }

        // Rompemos la referencia
        unset($currentChildren);
    }

    /**
     * Obtén todo el árbol como un array.
     */
    public function getTree(): array
    {
        return $this->tree;
    }

    /**
     * (Opcional) Retorna como JSON con las opciones que quieras.
     */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->tree, $options);
    }
}
