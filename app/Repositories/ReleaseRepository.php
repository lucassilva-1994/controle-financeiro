<?php

namespace App\Repositories;

use App\Models\Release;

class ReleaseRepository {

    public static function createOrUpdate(array $input) {
        if (isset($input["file"])) {
            $path = $input["file"]->store(session()->get("user"));
            $input["file"] = $path;
        }
        $release = new Release($input);
        $input = $release->attributes;
        if (isset($input['id_release'])) {
            $release->where("id_release", $input['id_release'])->update($input);
        } else {
            $release->save();
        }
    }

    public static function removeOrRestore($id_release, $status) {
        Release::where("id_release", $id_release)->update(["status" => $status]);
    }

    public static function search($search, array $filter,$start,$end) {
        if ($search == "revenues") {
            
        } else if ($search == "expenses") {
            $releases = Release::whereBetween('date', [$filter])->where(['type' => "DESPESA", "status" => "ATIVO"])->orderBy('date', 'Asc')->paginate(10);
            $sum = Release::whereBetween('date', [$filter])->where(['type' => 'DESPESA', 'payment' => 'DÉBITO', "status" => "ATIVO"])->sum('value', $releases);
            $title = "Resultados";
            $start = Date("d/m/Y", strtotime($start));
            $end = Date("d/m/Y", strtotime($end));
            
        }
    }

}
