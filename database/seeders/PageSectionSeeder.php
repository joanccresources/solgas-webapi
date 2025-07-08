<?php

namespace Database\Seeders;

use App\Models\PageSection;
use Illuminate\Database\Seeder;

class PageSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PageSection::insert([
            ['id' => 1, 'name' => 'Banner', 'index' => 1, 'page_id' => 1, 'created_at' => '2025-01-08 02:12:24', 'updated_at' => '2025-01-08 02:12:24'],
            ['id' => 2, 'name' => 'Productos y servicios', 'index' => 2, 'page_id' => 1, 'created_at' => '2025-01-08 02:12:24', 'updated_at' => '2025-01-08 02:12:24'],
            ['id' => 3, 'name' => 'Distribuidores', 'index' => 3, 'page_id' => 1, 'created_at' => '2025-01-08 02:12:24', 'updated_at' => '2025-01-08 02:12:24'],
            ['id' => 4, 'name' => 'Experta solgas', 'index' => 4, 'page_id' => 1, 'created_at' => '2025-01-08 02:12:24', 'updated_at' => '2025-01-08 02:12:24'],
            ['id' => 5, 'name' => 'Banner', 'index' => 1, 'page_id' => 2, 'created_at' => '2025-01-08 02:12:24', 'updated_at' => '2025-01-08 02:12:24'],
            ['id' => 6, 'name' => 'Propuesta de valor', 'index' => 2, 'page_id' => 2, 'created_at' => '2025-01-08 02:12:24', 'updated_at' => '2025-01-08 02:12:24'],
            ['id' => 7, 'name' => 'Formulario', 'index' => 3, 'page_id' => 2, 'created_at' => '2025-01-08 02:12:24', 'updated_at' => '2025-01-08 02:12:24'],
            ['id' => 8, 'name' => 'Banner', 'index' => 1, 'page_id' => 3, 'created_at' => '2025-01-08 02:12:24', 'updated_at' => '2025-01-08 02:12:24'],
            ['id' => 9, 'name' => 'Valores solgas', 'index' => 2, 'page_id' => 3, 'created_at' => '2025-01-08 02:12:24', 'updated_at' => '2025-01-08 02:12:24'],
            ['id' => 10, 'name' => 'Historias inspiradoras', 'index' => 3, 'page_id' => 3, 'created_at' => '2025-01-08 02:12:24', 'updated_at' => '2025-01-08 02:12:24'],
            ['id' => 11, 'name' => 'Trabaja con nosotros', 'index' => 4, 'page_id' => 3, 'created_at' => '2025-01-08 02:12:24', 'updated_at' => '2025-01-08 02:12:24'],
            ['id' => 14, 'name' => 'Productos', 'index' => 1, 'page_id' => 5, 'created_at' => '2025-01-15 10:21:06', 'updated_at' => '2025-01-15 10:21:06'],
            ['id' => 15, 'name' => 'Conoce más', 'index' => 2, 'page_id' => 5, 'created_at' => '2025-01-15 10:29:28', 'updated_at' => '2025-01-15 10:36:20'],
            ['id' => 16, 'name' => 'Experta solgas', 'index' => 3, 'page_id' => 5, 'created_at' => '2025-01-15 10:33:50', 'updated_at' => '2025-01-15 10:33:50'],
            ['id' => 17, 'name' => '¿Por qué solgas?', 'index' => 4, 'page_id' => 5, 'created_at' => '2025-01-15 10:35:20', 'updated_at' => '2025-01-15 10:36:44'],
            ['id' => 18, 'name' => 'Banner', 'index' => 1, 'page_id' => 6, 'created_at' => '2025-01-16 02:06:38', 'updated_at' => '2025-01-16 02:06:38'],
            ['id' => 19, 'name' => 'Beneficios', 'index' => 2, 'page_id' => 6, 'created_at' => '2025-01-16 02:06:50', 'updated_at' => '2025-01-16 02:06:50'],
            ['id' => 20, 'name' => 'Usos', 'index' => 3, 'page_id' => 6, 'created_at' => '2025-01-16 02:07:02', 'updated_at' => '2025-01-16 02:07:02'],
            ['id' => 21, 'name' => 'Presentaciones', 'index' => 4, 'page_id' => 6, 'created_at' => '2025-01-16 02:07:23', 'updated_at' => '2025-01-16 02:07:23'],
            ['id' => 24, 'name' => 'Adquiere tu balón', 'index' => 5, 'page_id' => 6, 'created_at' => '2025-01-16 02:20:06', 'updated_at' => '2025-01-16 02:20:06'],
            ['id' => 25, 'name' => 'Reconocimiento del balón', 'index' => 6, 'page_id' => 6, 'created_at' => '2025-01-16 02:20:11', 'updated_at' => '2025-01-16 02:20:11'],
            ['id' => 26, 'name' => 'Distribuidores', 'index' => 7, 'page_id' => 6, 'created_at' => '2025-01-16 02:20:18', 'updated_at' => '2025-01-16 02:20:18'],
            ['id' => 27, 'name' => 'Banner', 'index' => 1, 'page_id' => 7, 'created_at' => '2025-01-19 10:13:49', 'updated_at' => '2025-01-19 10:13:49'],
            ['id' => 28, 'name' => 'Banner', 'index' => 1, 'page_id' => 8, 'created_at' => '2025-01-19 10:13:54', 'updated_at' => '2025-01-19 10:13:54'],
            ['id' => 29, 'name' => 'Beneficios', 'index' => 2, 'page_id' => 7, 'created_at' => '2025-01-19 11:09:08', 'updated_at' => '2025-01-19 11:09:08'],
            ['id' => 30, 'name' => 'Usos', 'index' => 3, 'page_id' => 7, 'created_at' => '2025-01-19 11:09:31', 'updated_at' => '2025-01-19 11:09:31'],
            ['id' => 31, 'name' => 'Beneficios', 'index' => 2, 'page_id' => 8, 'created_at' => '2025-01-19 11:15:07', 'updated_at' => '2025-01-19 11:15:07'],
            ['id' => 32, 'name' => 'Reconocimiento del balón', 'index' => 4, 'page_id' => 7, 'created_at' => '2025-01-19 11:16:07', 'updated_at' => '2025-01-19 11:16:07'],
            ['id' => 33, 'name' => 'Distribuidores', 'index' => 5, 'page_id' => 7, 'created_at' => '2025-01-19 11:16:12', 'updated_at' => '2025-01-19 11:16:12'],
            ['id' => 34, 'name' => '¿Por qué ya no usar regulador tradicional?', 'index' => 3, 'page_id' => 8, 'created_at' => '2025-01-19 11:22:19', 'updated_at' => '2025-01-19 11:22:53'],
            ['id' => 35, 'name' => 'Adquiere tu balón 45kg', 'index' => 4, 'page_id' => 8, 'created_at' => '2025-01-19 11:23:32', 'updated_at' => '2025-01-19 11:23:32'],
            ['id' => 36, 'name' => 'Distribuidores', 'index' => 5, 'page_id' => 8, 'created_at' => '2025-01-19 11:23:43', 'updated_at' => '2025-01-19 11:23:43'],
            ['id' => 37, 'name' => 'Banner', 'index' => 1, 'page_id' => 9, 'created_at' => '2025-01-20 11:50:16', 'updated_at' => '2025-01-20 11:50:16'],
            ['id' => 38, 'name' => 'Beneficios', 'index' => 2, 'page_id' => 9, 'created_at' => '2025-01-20 11:50:22', 'updated_at' => '2025-01-20 11:50:22'],
            ['id' => 39, 'name' => 'Usos', 'index' => 3, 'page_id' => 9, 'created_at' => '2025-01-20 11:50:26', 'updated_at' => '2025-01-20 11:50:26'],
            ['id' => 40, 'name' => 'Reconocimiento del balón', 'index' => 4, 'page_id' => 9, 'created_at' => '2025-01-20 11:50:33', 'updated_at' => '2025-01-20 11:50:33'],
            ['id' => 41, 'name' => 'Distribuidores', 'index' => 5, 'page_id' => 9, 'created_at' => '2025-01-20 11:50:38', 'updated_at' => '2025-01-20 11:50:38'],
            ['id' => 42, 'name' => 'Productos', 'index' => 1, 'page_id' => 10, 'created_at' => '2025-01-20 11:58:17', 'updated_at' => '2025-01-20 11:58:17'],
            ['id' => 43, 'name' => 'Video', 'index' => 2, 'page_id' => 10, 'created_at' => '2025-01-20 11:58:36', 'updated_at' => '2025-01-20 11:58:36'],
            ['id' => 44, 'name' => '¿Por qué solgas?', 'index' => 3, 'page_id' => 10, 'created_at' => '2025-01-20 11:58:54', 'updated_at' => '2025-01-20 11:58:54'],
            ['id' => 45, 'name' => 'Distribuidores', 'index' => 4, 'page_id' => 10, 'created_at' => '2025-01-20 11:59:12', 'updated_at' => '2025-01-20 11:59:12'],
            ['id' => 46, 'name' => 'Banner', 'index' => 1, 'page_id' => 11, 'created_at' => '2025-01-21 01:13:44', 'updated_at' => '2025-01-21 01:13:44'],
            ['id' => 47, 'name' => 'Beneficios', 'index' => 2, 'page_id' => 11, 'created_at' => '2025-01-21 01:25:48', 'updated_at' => '2025-01-21 01:25:48'],
            ['id' => 48, 'name' => '¿Por qué confiar?', 'index' => 3, 'page_id' => 11, 'created_at' => '2025-01-21 01:26:46', 'updated_at' => '2025-01-21 01:35:06'],
            ['id' => 49, 'name' => '¿Cómo convertir?', 'index' => 4, 'page_id' => 11, 'created_at' => '2025-01-21 01:35:13', 'updated_at' => '2025-01-21 01:35:13'],
            ['id' => 50, 'name' => 'Simulador de ahorro', 'index' => 5, 'page_id' => 11, 'created_at' => '2025-01-21 01:36:25', 'updated_at' => '2025-01-21 01:36:25'],
            ['id' => 51, 'name' => 'Banner', 'index' => 1, 'page_id' => 13, 'created_at' => '2025-01-21 02:02:31', 'updated_at' => '2025-01-21 02:02:31'],
            ['id' => 52, 'name' => 'Reporte', 'index' => 2, 'page_id' => 13, 'created_at' => '2025-01-21 02:03:19', 'updated_at' => '2025-01-21 02:03:19'],
            ['id' => 53, 'name' => 'Hitos', 'index' => 3, 'page_id' => 13, 'created_at' => '2025-01-21 02:03:23', 'updated_at' => '2025-01-21 02:03:23'],
            ['id' => 54, 'name' => 'Pilares', 'index' => 4, 'page_id' => 13, 'created_at' => '2025-01-21 02:03:27', 'updated_at' => '2025-01-21 02:03:27'],
            ['id' => 55, 'name' => 'Certificaciones', 'index' => 5, 'page_id' => 13, 'created_at' => '2025-01-21 02:03:35', 'updated_at' => '2025-01-21 02:03:35'],
            ['id' => 56, 'name' => 'Reconocimientos', 'index' => 6, 'page_id' => 13, 'created_at' => '2025-01-21 02:43:45', 'updated_at' => '2025-01-21 02:43:45'],
            ['id' => 57, 'name' => 'Aporte pais', 'index' => 1, 'page_id' => 15, 'created_at' => '2025-01-21 02:58:38', 'updated_at' => '2025-01-21 02:58:38'],
            ['id' => 58, 'name' => 'Banner', 'index' => 1, 'page_id' => 14, 'created_at' => '2025-01-21 03:22:11', 'updated_at' => '2025-01-21 03:22:11'],
            ['id' => 59, 'name' => 'Promociones', 'index' => 2, 'page_id' => 14, 'created_at' => '2025-01-21 03:22:58', 'updated_at' => '2025-01-21 03:22:58'],
            ['id' => 60, 'name' => '¿Tienes una estación de servicio?', 'index' => 1, 'page_id' => 12, 'created_at' => '2025-01-22 19:12:07', 'updated_at' => '2025-01-22 19:12:07'],
            ['id' => 61, 'name' => 'Filtros', 'index' => 1, 'page_id' => 16, 'created_at' => '2025-01-29 09:46:26', 'updated_at' => '2025-01-29 09:46:26'],
            ['id' => 62, 'name' => 'Pedidos y atención al cliente', 'index' => 1, 'page_id' => 17, 'created_at' => '2025-02-04 07:21:53', 'updated_at' => '2025-02-04 07:21:53'],
            ['id' => 63, 'name' => 'Consulta adicional', 'index' => 2, 'page_id' => 17, 'created_at' => '2025-02-04 07:22:02', 'updated_at' => '2025-02-04 07:22:02'],
            ['id' => 64, 'name' => 'Formulario', 'index' => 3, 'page_id' => 17, 'created_at' => '2025-02-04 07:22:08', 'updated_at' => '2025-02-04 07:22:08'],
            ['id' => 65, 'name' => 'Emergencias', 'index' => 4, 'page_id' => 17, 'created_at' => '2025-02-04 07:22:14', 'updated_at' => '2025-02-05 16:17:50'],
            ['id' => 66, 'name' => 'Redes sociales', 'index' => 5, 'page_id' => 17, 'created_at' => '2025-02-04 07:22:19', 'updated_at' => '2025-02-04 07:22:19'],
        ]);
    }
}
