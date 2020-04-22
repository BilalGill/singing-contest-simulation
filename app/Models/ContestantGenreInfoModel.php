<?php namespace App\Models;

use App\Entities\ContestantGenreInfoEntity;
use CodeIgniter\Model;

class ContestantGenreInfoModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'contestants_genre_info';
    protected $primaryKey = 'id';
    protected $allowedFields = ['contestant_id', 'genre_id', 'strength'];
    protected $returnType = 'App\Entities\ContestantGenreInfoEntity';


    /**
     * @param ContestantGenreInfoEntity $contestGenreInfo
     * @return bool|int|string
     * @throws \ReflectionException
     */
    public function createContestantGenreInfo(ContestantGenreInfoEntity $contestGenreInfo)
    {
        return $this->insert($contestGenreInfo);
    }

    public function getContestantGenre($contestant_id, $genre_id)
    {
        return $this->whereIn('contestant_id', $contestant_id)->where('genre_id', $genre_id)->findAll();
    }
}