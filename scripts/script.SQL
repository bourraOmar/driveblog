CREATE DATABASE driveloc2;

USE driveloc2;

CREATE TABLE role (
    role_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(225) NOT NULL
);

CREATE TABLE user (
    user_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    FOREIGN KEY (role_id) REFERENCES role(role_id)
);

CREATE TABLE Categorie (
    Categorie_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    description VARCHAR(255)
);

CREATE TABLE vehicule (
    vehicule_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    modele VARCHAR(255) NOT NULL,
    marque VARCHAR(255) NOT NULL,
    prix FLOAT NOT NULL,
    status ENUM('active', 'Maintenance', 'Reserved'),
    vehicule_image VARCHAR(225),
    Categorie_id INT NOT NULL,
    FOREIGN KEY (Categorie_id) REFERENCES Categorie(Categorie_id) ON DELETE CASCADE
);

CREATE TABLE reservation (
    reservation_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    status ENUM('waiting', 'accepte', 'refuse'),
    user_id INT NOT NULL,
    vehicule_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES user(user_id),
    FOREIGN KEY (vehicule_id) REFERENCES vehicule(vehicule_id) ON DELETE CASCADE
);

CREATE TABLE avis (
    avis_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    commentaire VARCHAR(225),
    date_creation DATE,
    user_id INT NOT NULL,
    vehicule_id INT NOT NULL,
    status ENUM('active', 'archived'),
    FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE,
    FOREIGN KEY (vehicule_id) REFERENCES vehicule(vehicule_id) ON DELETE CASCADE
);

CREATE TABLE theme {
    theme_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(225),
    description VARCHAR(225),
    date_creation datetime
}

CREATE TABLE article {
    article_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    theme_id INT,
    title VARCHAR(225),
    content VARCHAR(225) NOT NULL,
    Approved BOOLEAN,
    date_creation datetime,
    FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE,
    FOREIGN KEY (theme_id) REFERENCES theme(theme_id) ON DELETE CASCADE 
};

CREATE TABLE comments {
    comments_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    article_id INT,
    content VARCHAR(225) NOT NULL,
    date_creation datetime,
    FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE,
    FOREIGN KEY (article_id) REFERENCES article(article_id) ON DELETE CASCADE
};

CREATE TABLE tag {
    tag_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    date_creation datetime
};

CREATE TABLE Article_tag (
    article_id INT NOT NULL,
    tag_id INT NOT NULL,
    CreatedDate DATETIME,
    PRIMARY KEY (article_id, tag_id),
    FOREIGN KEY (article_id) REFERENCES article(article_id),
    FOREIGN KEY (tag_id) REFERENCES tag(tag_id)
);


CREATE VIEW showAllVehicule AS
SELECT v.*, c.nom
FROM vehicule v
LEFT JOIN Categorie c
ON v.Categorie_id = c.Categorie_id;

DELIMITER $$

CREATE PROCEDURE ReserverVehicule(
    IN p_date_debut DATE, 
    IN p_date_fin DATE, 
    IN p_client_id INT, 
    IN p_vehicule_id INT
)
BEGIN

    INSERT INTO reservation (date_debut, date_fin, status, user_id, vehicule_id)
    VALUES (p_date_debut, p_date_fin, 'waiting', p_client_id, p_vehicule_id);
    
END $$

DELIMITER ;

-- for comment of articles 
SELECT a.*, t.*, c.*, at.tag_id FROM article a LEFT JOIN theme t ON a.theme_id = t.theme_id LEFT JOIN comments c ON a.article_id = c.article_id LEFT JOIN Article_tag at ON a.article_id = at.article_id;

-- articles with details and themes
SELECT a.*, t.*
FROM article a
LEFT JOIN theme t ON a.theme_id = t.theme_id;

-- articles with tags : 
SELECT a.*, t.*, at.tag_id, tag.name as tag_name
FROM article a
LEFT JOIN theme t ON a.theme_id = t.theme_id
LEFT JOIN Article_tag at ON a.article_id = at.article_id
LEFT JOIN tag ON at.tag_id = tag.tag_id;

SELECT a.article_id, a.title, a.content, a.article_image, a.date_creation, GROUP_CONCAT(t.name SEPARATOR ',') AS tags
FROM article a
LEFT JOIN Article_tag at ON a.article_id = at.article_id
LEFT JOIN tag t ON at.tag_id = t.tag_id
GROUP BY a.article_id;

SELECT t.* from tag t INNER join article_tag art on art.tag_id = t.tag_id where art.article_id = :article_id;

SELECT SUBSTRING(description, 1, 100) AS short_description FROM your_table;