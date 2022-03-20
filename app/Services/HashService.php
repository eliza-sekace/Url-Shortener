<?php
namespace App\Services;


class HashService
{
    private string $allowedChars = "abcdfghjkmnpqrstvwxyz|ABCDFGHJKLMNPQRSTVWXYZ|0123456789|!@$%";
    private int $maxUrlLength = 8;

    public function createHash():string
    {
        $sets = explode('|', $this->allowedChars);
        $all = '';
        $hash = '';
        foreach ($sets as $set) {
            $hash .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        $hash .= str_repeat($all[array_rand($all)], $this->maxUrlLength - count($sets));
        return str_shuffle($hash);
    }


}