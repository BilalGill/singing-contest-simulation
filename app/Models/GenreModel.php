<?php namespace App\Models;

use App\Entities\GenreEntity;
use CodeIgniter\Model;

class GenreModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'genre';
    protected $primaryKey = 'id';
    protected $allowedFields = ['genre'];
    protected $returnType = 'App\Entities\GenreEntity';

    /**
     * @return array|null
     */
    public function getAllGenres()
    {
        return $this->findAll();
    }

    /**
     * @param $genre_id
     * @return GenreEntity
     */
    public function getGenres($genre_id) : GenreEntity
    {
        return $this->find($genre_id);
    }

    public function getRandomGenre()
    {
        return $this->orderBy("RAND()")->findAll();
    }
}