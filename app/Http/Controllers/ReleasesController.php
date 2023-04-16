<?php
namespace App\Http\Controllers;
use App\Http\Requests\ReleaseRequest;
use Illuminate\Http\Request;
use App\Models\Release;
use Illuminate\Support\Facades\DB;
use DateTime;

class ReleasesController extends Controller
{
    public function index(Request $request)
    {
        return view("release.releases");
    }

    public function new()
    {
        $categories = $this->getListCategory();
        $releases = Release::where("status", "ATIVO")->orderBy("id_release", "desc")->limit(5)->get();
        return view("release.new", compact("categories", "releases"));
    }

    public function edit($id_release)
    {
        $release = Release::where(["id_release" => $id_release])->first();
        $categories = $this->getListCategory();

        return view("release.edit", compact("release", "categories"));
    }

    public function create(ReleaseRequest $request)
    {
        Release::createOrUpdate($request->all());
        return redirect()->back()->with("success", "Lançamento cadastrado com sucesso.");
    }

    public function update(Request $request)
    {
        Release::createOrUpdate($request->all());
        return redirect()->back()->with("success", "Lançamento atualizado com sucesso.");
    }

    public function junk()
    {
        $junks = Release::where(['status' => 'INATIVO'])->orderByDesc('date')->get();
        return view('release.junks', compact('junks'));
    }

    public function remove($id_release)
    {
        Release::removeOrRestore($id_release, "INATIVO");
        return redirect()->back()->with("success", "Lançamento removido com sucesso.");
    }

    public function restore($id_release)
    {
        Release::removeOrRestore($id_release, "ATIVO");
        return redirect()->back()->with("success", "Lançamento restaurado com sucesso.");
    }

    public function delete($id_release)
    {
        Release::where(["id_release" => $id_release, "status" => "INATIVO"])->delete();
        return redirect()->back()->with("success", "Lançamento excluído com sucesso.");
    }

    private function getListCategory()
    {
        return DB::table("categories")->orderBy("name", "asc")->get();
    }
}
