--CREATE TABLE areas_zonas_educativas (id_zona serial primary key,id_nivel integer, the_geom geometry(MULTIPOLYGON,4326),nombre_leyenda character varying, descripcion character varying,FOREIGN KEY (id_nivel) REFERENCES niveles(id_nivel))

DO $$
DECLARE
geom geometry(MULTIPOLYGON,4326);
_areas record;

BEGIN 
FOR _areas IN SELECT * FROM areas_bachiller LOOP
	geom = ST_TRANSFORM(_areas.geom,4326);
	INSERT INTO areas_zonas_educativas (id_nivel,the_geom,nombre_leyenda,descripcion) VALUES (3,geom,_areas.area,_areas.descripcion);
	INSERT INTO areas_zonas_educativas (id_nivel,the_geom,nombre_leyenda,descripcion) VALUES (2,geom,_areas.area,_areas.descripcion);



END LOOP;

FOR _areas IN SELECT DISTINCT nombre,* FROM distritos_primaria LOOP
	geom = ST_TRANSFORM(_areas.geom,4326);
	INSERT INTO areas_zonas_educativas (id_nivel,the_geom,nombre_leyenda,descripcion) VALUES (1,geom,_areas.nombre,_areas.nombre);
	INSERT INTO areas_zonas_educativas (id_nivel,the_geom,nombre_leyenda,descripcion) VALUES (4,geom,_areas.nombre,_areas.nombre);



END LOOP;





END $$