CREATE OR REPLACE VIEW alumno_datos_geoserver AS
SELECT alumno.nombre_alumno,alumno.apellidos_alumno,niveles.nombre as nombre_nivel,tipos_educativo.nombre as nombre_tipo_educativo,area.nombre_leyenda as nombre_area,via.nombre_via,portal.num_policia,
area.id_zona,alumno.id_alumno as id_alumno,niveles.id_nivel as id_nivel,tipos_educativo.id_tipo as id_tipo_educativo,via.id_vial as id_via,portal.id as id_portal,
area.the_geom as the_geom_area,ST_TRANSFORM((via.geom),4326) as the_geom_via,ST_TRANSFORM((portal.geom),4326) as the_geom_portal
FROM alumnos as alumno
	  JOIN niveles as niveles ON id_nivel = alumno.id_nivel_educativo 
	  JOIN tipos_educativos as tipos_educativo ON id_tipo = alumno.id_tipo_educativo 
	  JOIN viales as via ON id_vial = alumno.calc_id_calle
	  JOIN portales as portal ON id = alumno.calc_id_num_poli
	  JOIN areas_zonas_educativas  as area ON id_zona = alumno.calc_id_zona

	  

