<?php namespace App\Models;

use CodeIgniter\Model;

class ContestantModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'contestants';
    protected $primaryKey = 'id';
    protected $allowedFields = ['date_created'];
    protected $returnType = 'App\Entities\ContestantEntity';
}