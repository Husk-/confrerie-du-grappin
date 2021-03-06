<?php

namespace Tee\TeeworldsBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * StatisticsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StatisticsRepository extends EntityRepository
{
	public function getStatisticsByGame( $game )
	{
		$qb = $this->_em->createQueryBuilder();
		$qb->select("s");
		$qb->from("TeeworldsBundle:Statistics", "s");
		$qb->where( "s.game = :game ");
		$qb->setParameter( "game", $game);
		
		return $qb->getQuery()->getResult();
	}

	public function getTotalStatistics()
	{
		$qb = $this->_em->createQueryBuilder();
		$qb->select("p.nickname as player, SUM(s.frag) as kill, SUM(s.death) as death, SUM(s.suicide) as suicide, SUM(s.weaponSuicide) as weaponSuicide, SUM(s.teamkill) as teamKill ");
		$qb->from("TeeworldsBundle:Statistics", "s");
		$qb->leftJoin("s.player","p");
		$qb->groupBy( "p.nickname ");
		
		return $qb->getQuery()->getResult( Query::HYDRATE_ARRAY );
	}
}
