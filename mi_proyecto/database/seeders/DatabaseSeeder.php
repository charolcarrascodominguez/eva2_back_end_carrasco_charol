?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Usuarios: 1 reclutador y 2 candidatos
        DB::table('usuario')->insert([
            [
                'rut_usuario' => '12345678-9',
                'nombre' => 'Charol',
                'apellido' => 'Carrasco',
                'email' => 'reclutador@clientefeliz.cl',
                'password' => Hash::make('1234seguro'),
                'rol' => 'reclutador'
            ],
            [
                'rut_usuario' => '22345678-9',
                'nombre' => 'Ana',
                'apellido' => 'Pérez',
                'email' => 'ana@correo.com',
                'password' => Hash::make('5678seguro'),
                'rol' => 'candidato'
            ],
            [
                'rut_usuario' => '32345678-9',
                'nombre' => 'Luis',
                'apellido' => 'López',
                'email' => 'luis@correo.com',
                'password' => Hash::make('9101seguro'),
                'rol' => 'candidato'
            ]
        ]);

        // Candidatos (datos extra si quieres tenerlo en tabla candidatos)
        DB::table('candidato')->insert([
            [
                'rut_cantidado' => '22345678-9',
                'nombre' => 'Ana',
                'apellido' => 'Pérez',
                'email' => 'ana@correo.com',
                'profesion' => 'Químico'
            ],
            [
                'rut_cantidado' => '32345678-9',
                'nombre' => 'Luis',
                'apellido' => 'López',
                'email' => 'luis@correo.com',
                'profesion' => 'Ingeniero'
            ]
        ]);

        // Ofertas laborales
        DB::table('ofertas_laborales')->insert([
            [
                'titulo' => 'Ejecutivo de Ventas',
                'descripcion' => 'Responsable de ventas telefónicas a clientes nuevos y existentes.',
                'fecha_publicacion' => '2024-06-05',
                'estado' => 'activa',
                'rut_usuario' => '12345678-9'
            ],
            [
                'titulo' => 'Supervisor',
                'descripcion' => 'Encargado de supervisar equipos de ventas.',
                'fecha_publicacion' => '2024-06-07',
                'estado' => 'activa',
                'rut_usuario' => '12345678-9'
            ]
        ]);

        // Postulaciones
        DB::table('postulaciones')->insert([
            [
                'id_oferta' => 1,
                'rut_candidato' => '22345678-9',
                'fecha_postulacion' => '2024-06-08',
                'estado' => 'Revisando',
                'comentario' => '',
                'ultima_actualizacion' => '2024-06-09'
            ],
            [
                'id_oferta' => 1,
                'rut_candidato' => '32345678-9',
                'fecha_postulacion' => '2024-06-08',
                'estado' => 'Postulando',
                'comentario' => '',
                'ultima_actualizacion' => '2024-06-09'
            ],
            [
                'id_oferta' => 2,
                'rut_candidato' => '22345678-9',
                'fecha_postulacion' => '2024-06-10',
                'estado' => 'Entrevista Psicológica',
                'comentario' => 'Listo para entrevista psicológica',
                'ultima_actualizacion' => '2024-06-12'
            ]
        ]);
    }
}
