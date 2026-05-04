use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfertasLaboralesTable extends Migration
{
    public function up()
    {
        Schema::create('ofertas_laborales', function (Blueprint $table) {
            $table->id('id_oferta');
            $table->string('titulo', 100);
            $table->text('descripcion');
            $table->date('fecha_publicacion');
            $table->string('estado', 20);
            $table->string('rut_usuario', 20);
            $table->foreign('rut_usuario')->references('rut_usuario')->on('usuario');
        });
    }
    public function down()
    {
        Schema::dropIfExists('ofertas_laborales');
    }
}
