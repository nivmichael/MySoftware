TABLE users(
   id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
   username     VARCHAR(50) UNIQUE NOT NULL,
   password     VARCHAR(50) NOT NULL,
   name         VARCHAR(50) NOT NULL,
   address      VARCHAR(100),
   created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   last_login   TIMESTAMP NULL,
   PRIMARY KEY ( id )
);

TABLE posts(    
   id           INT UNSIGNED NOT NULL AUTO_INCREMENT,    
   user_id      INT UNSIGNED NOT NULL INDEX user_id_index,    
   title        VARCHAR(100) NOT NULL,    
   body         TEXT NOT NULL,    
   file_path    VARCHAR(255),    
   uploaded_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,    
   PRIMARY KEY ( id ),
   FOREIGN KEY (user_id) REFERENCES users(id)
);