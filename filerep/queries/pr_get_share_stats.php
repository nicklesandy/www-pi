<?php

$qry_share_stats = mysql_query("
	select
		s.id_share,
		s.name,
		s.info,
		s.server_directory,
		count(distinct hs.id_host_share) - 1 as hosts_linked,
		max(ifnull(hs.date_last_replicated,0)) as max_date_last_replicated,
		s.total_files as nbr_files,
		s.total_filesize as total_file_size,
		s.date_last_modified as max_date_last_modified,
		count(distinct d.id_directory) as nbr_dirs,
		sum(case when d.date_last_checked is null then 0 else 1 end) as dirs_checked
	
	from t_share s
		join t_host_share hs on hs.id_share = s.id_share
			and hs.active = 1
		left join t_directory d on d.id_share = s.id_share
			and d.active = 1
	where
		s.active = 1
		
	group by
		s.id_share,
		s.name,
		s.info,
		s.server_directory,
		s.total_files,
		s.total_filesize,
		s.date_last_modified 
		
	order by
		s.name
		
	", $conn);
	
?>