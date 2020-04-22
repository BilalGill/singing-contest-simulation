<?php namespace App\Models;

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
     * @return array|object|null
     */
    public function getGenres($genre_id)
    {
        return $this->find($genre_id);
    }

    /**
     * @return array|null
     */
    public function getRandomGenre()
    {
        return $this->orderBy("RAND()")->findAll();
    }
}