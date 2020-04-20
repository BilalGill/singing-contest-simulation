<?php namespace App\Models;

use CodeIgniter\Model;

class ContestantGenreInfoModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'contestants_genre_info';
    protected $primaryKey = 'id';
    protected $allowedFields = ['contestant_id','genre_id','strength'];
    protected $returnType = 'App\Entities\ContestantGenreInfoEntity';
}