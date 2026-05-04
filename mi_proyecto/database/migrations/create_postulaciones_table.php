use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostulacionesTable extends Migration
{
    public function up()
    {
        Schema::create('postulaciones', function (Blueprint $table) {
            $table->id('id_postulacion');
            $table->unsignedBigInteger('id_oferta');
            $table->string('rut_candidato', 20);
            $table->date('fecha_postulacion');
            $table->string('estado', 30);
            $table->text('comentario')->nullable();
            $table->date('ultima_actualizacion');
            $table->foreign('id_oferta')->references('id_oferta')->on('ofertas_laborales');
            $table->foreign('rut_candidato')->references('rut_usuario')->on('usuario');
        });
    }
    public function down()
    {
        Schema::dropIfExists('postulaciones');
    }
}
