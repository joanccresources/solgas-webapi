<?php

namespace App\Traits;

use App\Models\Module;

trait ModulesTrait
{
    private const ICON_FOLDER_IMAGE =  DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'icons' . DIRECTORY_SEPARATOR;

    /**
     * Process Modules And Permission en Central
     *
     * @return array
     */
    protected function getModulesAndPermission($permissions): array
    {
        $modules = $this->getModules();
        $array_resources = collect($this->operationForPermissions())->pluck('id');

        return $this->getLogicProcessToObtainTheModules($permissions, $modules, $array_resources);
    }

    protected function getLogicProcessToObtainTheModules($permissions, $modules, $array_resources, $activeModulePlans = [])
    {
        $permissions_process = array();

        foreach ($modules as $valueMod) {
            $submodules = array();
            if (!isset($valueMod['submodules'])) { //notiene submodulos
                $resources = $this->detectResourcesPermission($permissions, $array_resources, $valueMod);
            } else {
                foreach ($valueMod['submodules'] as $valueSub) {
                    $resources = $this->detectResourcesPermission($permissions, $array_resources, $valueSub);
                    if (COUNT($resources) > 0) {
                        array_push($submodules, array_merge($valueSub, ['resources' => $resources]));
                    }
                }
                $resources = []; // se limpia para que no afecte cuando es módulo
            }

            if ((COUNT($submodules) > 0 || COUNT($resources) > 0)) {
                array_push(
                    $permissions_process,
                    array_merge(
                        $valueMod,
                        ['submodules' => $submodules, 'resources' => $resources]
                    )
                );
            }
        }

        return $permissions_process;
    }

    protected function detectResourcesPermission($permissions, $array_resources, $valueMod)
    {
        $resources = array();
        foreach ($permissions as $value) {
            foreach ($array_resources as $valueRes) {
                if ($value->name == $valueMod['assigned'] .  $valueRes) {
                    array_push($resources, $valueRes);
                }
            }
        }
        return $resources;
    }

    /**
     * Array Modules Central
     *
     * @return array
     */
    protected function getModules()
    {
        $modules = Module::where('active', true)->orderby('index', 'asc')->get();
        $array_modules = array();
        foreach ($modules as $key => $value) {
            if (!$value->module_id) {
                $array_submodule = array();
                foreach ($modules as $keySub => $valueSub) {
                    if ($valueSub->module_id == $value->id) {
                        array_push(
                            $array_submodule,
                            [
                                'id' => $valueSub->id,
                                'name' => $valueSub->name,
                                'show_in_sidebar' => $valueSub->show_in_sidebar,
                                'singular_name' => $valueSub->singular_name,
                                'assigned' => $valueSub->assigned,
                                'slug' => $valueSub->slug,
                                'per_page' => $valueSub->is_crud ? $valueSub->per_page : null,
                                'page' => $valueSub->is_crud ? $valueSub->page : null,
                                'sort_by' => $valueSub->is_crud ? $valueSub->sort_by : null,
                                'descending' => $valueSub->is_crud ? $valueSub->order_direction : null,

                                'endpoint' => $valueSub->endpoint,
                                'element' => $valueSub->element,
                                'additional_custom_actions' => $valueSub->additional_custom_actions,
                                'path' => $valueSub->path,
                                'path_format' => $valueSub->path_format,
                                'columns' => $valueSub->columns,
                                'columns_format' => $valueSub->columns_format,
                                'create_edit' => $valueSub->create_edit,
                                'create_edit_format' => $valueSub->create_edit_format
                            ]
                        );
                    }
                }
                $module =  [
                    'id' => $value->id,
                    'name' => $value->name,
                    'show_in_sidebar' => $value->show_in_sidebar,
                    'singular_name' => $value->singular_name,
                    'assigned' => $value->assigned,
                    'slug' => $value->slug,
                    'per_page' => $value->is_crud ? $value->per_page : null,
                    'page' => $value->is_crud ? $value->page : null,
                    'sort_by' => $value->is_crud ? $value->sort_by : null,
                    'descending' => $value->is_crud ? $value->order_direction : null,
                    'icon' => $value->icon,

                    'endpoint' => $value->endpoint,
                    'element' => $value->element,
                    'additional_custom_actions' => $value->additional_custom_actions,
                    'path' => $value->path,
                    'path_format' => $value->path_format,
                    'columns' => $value->columns,
                    'columns_format' => $value->columns_format,
                    'create_edit' => $value->create_edit,
                    'create_edit_format' => $value->create_edit_format

                ];
                if (COUNT($array_submodule) > 0) {
                    $module = array_merge($module, ['submodules' => $array_submodule]);
                }

                array_push(
                    $array_modules,
                    $module
                );
            }
        }

        return $array_modules;
    }

    protected function operationForPermissions()
    {
        return array(
            array('id' => 'index', 'name' => 'Listar'),
            array('id' => 'create', 'name' => 'Registrar'),
            array('id' => 'edit', 'name' => 'Editar'),
            array('id' => 'destroy', 'name' => 'Eliminar'),
            array('id' => 'order', 'name' => 'Ordenar'),
            array('id' => 'download', 'name' => 'Descargar')
        );
    }

    protected function orderDirections()
    {
        return  array(
            array('id' => 'ASC', 'name' => 'Ascendente'),
            array('id' => 'DESC', 'name' => 'Descendente')
        );
    }
}
