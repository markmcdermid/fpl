 SELECT
	fixtures.`date`,
	t.`team_name`,
	o.team_name,
	tr.`home_score`,
	tr.away_score
	
from fixtures 
left join 
	teams t  
	on fixtures.`team_id`=t.`team_id`
left join teams o 
	on fixtures.opp_id = o.team_id
left join team_results tr
	on fixtures.`fixture_id` = tr.`home_fixture_id` 
where 
fixtures.team_id = t.`team_id` 
and 
fixtures.homeoraway = "H" 
and 
fixtures.gameweek = 'Gameweek 03'
order by
 fixtures.date,
 t.team_name asc