<?php
namespace App\Http\Controllers;
use App\Http\Requests\ReleaseRequest;
use Illuminate\Http\Request;
use App\Models\Release;
use Illuminate\Support\Facades\DB;
use DateTime;

class ReleasesController extends Controller
{
    private function dateConvert($date, $format = "Y-m-d")
    {
        $newDate = new DateTime($date);
        return $newDate->format($format);
    }

    private function valuesCalculate($list)
    {
        $balance = ["expenses" => 0, "revenues" => 0];
        foreach ($list as $item) {
            $value = str_replace([".", ","], ["", "."], $item["value"]);
            if ($item["type"] == "DESPESA" && $item["payment"] == "DÉBITO") {
                $balance["expenses"] += $value;
            }
            if ($item["type"] == "RECEITA" && $item["payment"] == "DÉBITO") {
                $balance["revenues"] += $value;
            }
        }
        return $balance;
    }

    public function index(Request $request)
    {
        $title = "Lançamentos";
        $filter = ["status" => "ATIVO"];
        $dateFilter = [
            "initial" => empty($request->start_date) ? date('Y-m-01') : $this->dateConvert($request->start_date),
            "final" => empty($request->end_date) ? date("Y-m-t") : $this->dateConvert($request->end_date)
        ];
        if($request->start_date > $request->end_date){
            return redirect()->back()->with("error","A data inicial não pode ser maior que a data final.");
        }
        if ($request->type) {
            $filter["type"] = $request->type;
        }
        $releases = Release::whereBetween("date", array_values($dateFilter))->where($filter)->orderBy("date","ASC")->paginate(15);
        $dataReleases = Release::whereBetween("date", array_values($dateFilter))->where($filter)->get()->toArray();
        $balance = $this->valuesCalculate($dataReleases);
        return view("release.releases", compact("title", "dateFilter", "releases", "balance"));
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
