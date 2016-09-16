DROP DATABASE IF EXISTS atlasikdb;
CREATE DATABASE atlasikdb;
USE atlasikdb;


CREATE TABLE errors(
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			title VARCHAR(100) NOT NULL,
			text VARCHAR(500)
			);
CREATE TABLE users(
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			slug VARCHAR(20) NOT NULL UNIQUE,
			email VARCHAR(80) NOT NULL UNIQUE,
			name VARCHAR(80) NOT NULL UNIQUE,
			phone VARCHAR(80) NULL,			
			activated_date INT NULL
			);
CREATE TABLE user_reg_data(
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			uid INT NOT NULL UNIQUE,
			pass_hash VARCHAR(40) NOT NULL,
			solt INT NOT NULL,
			iters INT NOT NULL,
			FOREIGN KEY(uid) REFERENCES users(id)
			);
CREATE TABLE manufs(
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(80) NOT NULL UNIQUE
			);
CREATE TABLE fotos(
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			file VARCHAR(80) NOT NULL UNIQUE
			);
CREATE TABLE groups(
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(80) NOT NULL UNIQUE,
			foto_id INT NULL,
			FOREIGN KEY(foto_id) REFERENCES fotos(id)
			);
CREATE TABLE caths(
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			group_id INT NULL,
			name VARCHAR(80) NOT NULL UNIQUE,
			foto_id INT NULL,
			FOREIGN KEY(foto_id) REFERENCES fotos(id),
			FOREIGN KEY(group_id) REFERENCES groups(id)
			);
CREATE TABLE goods(
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			slug VARCHAR(20) NOT NULL UNIQUE,
			cath_id INT NOT NULL,
			d_date INT NULL,
			name VARCHAR(80) NOT NULL,
			price INT NOT NULL,
			descr VARCHAR(400) NULL,
			manuf INT NOT NULL,
			consist VARCHAR(80) NOT NULL,
			width INT NOT NULL,
			main_foto_id INT NOT NULL,		
			FOREIGN KEY(cath_id) REFERENCES caths(id),	
			FOREIGN KEY(manuf) REFERENCES manufs(id),
			FOREIGN KEY(main_foto_id) REFERENCES fotos(id) ON DELETE CASCADE
			);

INSERT INTO errors(id,title,text)
	VALUES	(1,'Ваша учетная запись не активна','Для активации учетной записи требуется подтверждение электронного адреса. Для этого пожалуйста, следуйте инструкциям в письме, отправленном по данному электронному адресу, либо воспользуйтесь ссылкой для восстановления пароля. Спасибо!'),
			(2,'Что-то не так','Произошла какая-то непонятность... Если это повторяется, пожалуйста, напишите мне! Спасибо!');
INSERT INTO users(id,slug,name,phone,email,activated_date)
	VALUES	(1,'u_001','John Smith','+7(917)117-17-17','john@smith.loc',1468499077),
			(2,'u_002','Mike White','+7(902)111-11-11','mike@white.loc',1468499277),
			(3,'u_003','Not Active User',NULL,'not@active.user',NULL),
			(4,'u_004','Anonim User',NULL,'anonim@user.loc',1468500090);
INSERT INTO user_reg_data(uid,pass_hash,solt,iters)
	VALUES	(1,'51684c5c468cf340fff1ea640fe7c2d68ecfd1ca',1784945005,19),
			(2,'8b6c20edaa42700a450590f58286308d9cb3a8a7',1045074831,6),
			(3,'51684c5c468cf340fff1ea640fe7c2d68ecfd1ca',1784945005,19),
			(4,'8e1059495426af704ab9c5561f6fa7876b4f951a',2085205362,20);
INSERT INTO manufs(id,name)
	VALUES	(1,'Россия'),
			(2,'Италия'),
			(3,'Китай');
INSERT INTO fotos(id,file)
	VALUES	(1,'IMG_2406.JPG');
INSERT INTO groups(id,name,foto_id)
	VALUES	(1,'jins',1),
			(2,'empty group',NULL),
			(3,'group whit empty cath',NULL);	
INSERT INTO caths(id,name,group_id,foto_id)
	VALUES	(1,'jins printed',1,1),
			(2,'jins colored',1,1),
			(3,'alwais empty cath',NULL,NULL),
			(4,'atlas',NULL,1),
			(5,'cath for empty group',3,NULL);
INSERT INTO goods(id,slug,cath_id,d_date,name,price,descr,manuf,consist,width,main_foto_id)
	VALUES	(1,'g_001',2,1468496877,'jins #1',888,'Описание джинса номер один.',2,'хлопок 100%',140,1),
			(2,'g_002',4,1468497877,'atlas #1',1000,'Описание атласа номер один.',3,'хлопок 100%',140,1),
			(3,'g_003',2,1468496977,'jins #2',1888,'Описание джинса номер 2.',2,'хлопок 100%',140,1),
			(4,'g_004',1,1468497077,'jins #3',2888,'Описание джинса номер 3.',2,'хлопок 100%',140,1),
			(5,'g_005',1,1468498077,'jins #4',3888,'Описание джинса номер 4.',2,'хлопок 100%',140,1),
			(6,'g_006',1,1468499077,'jins #5',4888,'Описание джинса номер 5.',3,'хлопок 100%',140,1),
			(7,'g_007',1,1468499177,'jins #6',5888,'Описание джинса номер 6.',2,'хлопок 100%',140,1),
			(8,'g_008',1,1468499277,'jins #7',6888,'Описание джинса номер 7.',2,'хлопок 100%',140,1),
			(9,'g_009',1,1468500000,'jins #9',6888,'Описание джинса номер 9.',2,'хлопок 100%',140,1),
			(10,'g_010',1,1468500010,'jins #10',6888,'Описание джинса номер 9.',2,'хлопок 100%',140,1),
			(11,'g_011',1,1468500020,'jins #11',6888,'Описание джинса номер 9.',2,'хлопок 100%',140,1),
			(12,'g_012',1,1468500020,'jins #12',6888,'Описание джинса номер 9.',2,'хлопок 100%',140,1),
			(13,'g_013',1,1468500030,'jins #13',6888,'Описание джинса номер 9.',2,'хлопок 100%',140,1),
			(14,'g_014',1,1468500040,'jins #14',6888,'Описание джинса номер 9.',2,'хлопок 100%',140,1),
			(15,'g_015',1,1468500050,'jins #15',6888,'Описание джинса номер 9.',2,'хлопок 100%',140,1),
			(16,'g_016',1,1468500060,'jins #16',6888,'Описание джинса номер 9.',2,'хлопок 100%',140,1),
			(17,'g_017',1,1468500070,'jins #17',6888,'Описание джинса номер 9.',2,'хлопок 100%',140,1),
			(18,'g_018',1,1468500080,'jins #18',6888,'Описание джинса номер 9.',2,'хлопок 100%',140,1),
			(19,'g_019',1,1468500090,'jins #19',6888,'Описание джинса номер 9.',2,'хлопок 100%',140,1),
			(20,'g_020',1,1468500200,'jins #20',6888,'Описание джинса номер 9.',2,'хлопок 100%',140,1),
			(21,'g_021',1,1468500210,'jins #21',6888,'Описание джинса номер 9.',2,'хлопок 100%',140,1);

CREATE TABLE news(
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			slug VARCHAR(20) NOT NULL UNIQUE,
			news_date INT NOT NULL,
			title VARCHAR(200) NOT NULL,
			content VARCHAR(1000) NOT NULL
			);
INSERT INTO news(id,slug,news_date,title,content)
	VALUES	(1,'news_001',1468497077,'Первая новость','Содержание первой новости!z Содержание первой новости. Содержание первой новости. Содержание первой новости. Содержание первой новости. Содержание первой новости. Содержание первой новости. Содержание первой новости. Содержание первой новости.'),
			(2,'news_002',1468498177,'Вторая хорошая новость','Содержание второй хорошей новости. Содержание второй хорошей новости. Содержание второй хорошей новости. ');