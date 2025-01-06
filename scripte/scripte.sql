
  CREATE DATABASE DriveBlog;

  USE DriveBlog;

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

  CREATE TABLE categorie (
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
      FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE
  );
