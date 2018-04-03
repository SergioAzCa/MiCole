SELECT * from viales where nombre_via LIKE '%Marques%';
SELECT * from portales where id_vial = 462500002336

SELECT nombre_via, num_policia ,the_geom_portal FROM public.alumno_datos_geoserver  WHERE id_portal = 4554

SELECT COUNT(calc_id_zona),calc_id_zona,zonas.the_geom as the_geom_zonas FROM alumnos as alumnos
JOIN areas_zonas_educativas as zonas ON zonas.id_zona = alumnos.calc_id_zona
GROUP BY calc_id_zona,zonas.the_geom



SELECT COUNT(calc_id_zona)as contador,alumnos.calc_id_zona,alumnos.id_nivel_educativo,the_geom as the_geom_zonas FROM alumnos as alumnos
JOIN areas_zonas_educativas as zonas ON zonas.id_zona = alumnos.calc_id_zona
WHERE alumnos.id_nivel_educativo = 3
GROUP BY calc_id_zona,zonas.the_geom,id_nivel_educativo
