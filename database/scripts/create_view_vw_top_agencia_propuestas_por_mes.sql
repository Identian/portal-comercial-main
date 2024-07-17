CREATE VIEW VITO_COMERCIAL.vwTopAgenciaPropuestasPorMes AS
WITH TopPropuestasPorMes AS (
    SELECT id_agency, COUNT(*) as total_propuestas, MONTH(created_at) as mes, YEAR(created_at) as anio
    FROM VITO_COMERCIAL.propuesta
    GROUP BY id_agency, MONTH(created_at), YEAR(created_at)
),
RankingPorMes AS (
    SELECT id_agency, total_propuestas, mes, anio,
           ROW_NUMBER() OVER (PARTITION BY mes, anio ORDER BY total_propuestas DESC) as ranking
    FROM TopPropuestasPorMes
),
PropuestasConFirmas AS (
    SELECT id_agency, COUNT(*) as total_con_firmas, MONTH(created_at) as mes, YEAR(created_at) as anio
    FROM VITO_COMERCIAL.propuesta
    WHERE cant_firmas > 0
    GROUP BY id_agency, MONTH(created_at), YEAR(created_at)
)
SELECT RPM.mes, RPM.anio, RPM.id_agency, RPM.total_propuestas, COALESCE(PCF.total_con_firmas, 0) as total_con_firmas
FROM RankingPorMes RPM
LEFT JOIN PropuestasConFirmas PCF ON RPM.id_agency = PCF.id_agency AND RPM.mes = PCF.mes AND RPM.anio = PCF.anio
WHERE RPM.ranking <= 5;
