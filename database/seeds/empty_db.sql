-- Empty the current database's tables and reset autoincrement to 1

SET FOREIGN_KEY_CHECKS=0;

DELIMITER $$
CREATE PROCEDURE clearDb()
  BEGIN
    DECLARE oneTable CHAR(100);
    DECLARE finished INT DEFAULT 0;
    DEClARE allTables CURSOR FOR SELECT table_name FROM information_schema.tables WHERE table_schema=(SELECT DATABASE());
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;
    OPEN allTables;
    get_table: LOOP
      FETCH allTables INTO oneTable;
      IF finished = 1 THEN
        LEAVE get_table;
      END IF;
      set @qry1 := concat('delete from ',oneTable);
      prepare stmt from @qry1 ;
      execute stmt ;
      set @qry1 := concat('ALTER TABLE ',oneTable,' auto_increment=1');
      prepare stmt from @qry1 ;
      execute stmt ;
    END LOOP get_table;
    CLOSE allTables;
  END;
$$
CALL clearDb();
DROP PROCEDURE clearDb;

SET FOREIGN_KEY_CHECKS=1;
