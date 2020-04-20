<?php namespace App\Models;

use CodeIgniter\Model;

class GenreModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'genre';
    protected $primaryKey = 'id';
    protected $allowedFields = ['genre'];
    protected $returnType = 'App\Entities\GenreEntity';
}