<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220426114816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'init db';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE promocode_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE address_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "house_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "city_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');

        $this->addSql('CREATE TABLE promocode (id INT NOT NULL, name VARCHAR(255) NOT NULL, status INT DEFAULT 1,PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE promocode_user (promocode_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(promocode_id, user_id))');
        $this->addSql('CREATE TABLE city (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE house (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE address (id INT NOT NULL, index VARCHAR(255) DEFAULT NULL, flat VARCHAR(5) DEFAULT NULL, city_id INT DEFAULT NULL, house_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL,  surname VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL,email VARCHAR(180) DEFAULT NULL, roles JSON DEFAULT NULL, password VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, address_id INT DEFAULT NULL, sex BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');

        $this->addSql('CREATE INDEX IDX_749F46DDDD62C21B ON promocode (name)');
        $this->addSql('CREATE INDEX IDX_35AF9D73EF1A9D84 ON promocode_user (promocode_id)');
        $this->addSql('CREATE INDEX IDX_35AF9D73A76ED395 ON promocode_user (promocode_id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC12130303A ON address (city_id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC129F6EE60 ON address (house_id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC12130313A ON  "user" (address_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6497B8C0F06 ON "user" (email)');

        $this->addSql('ALTER TABLE promocode_user ADD CONSTRAINT FK_35AF9D73EF1A9D84 FOREIGN KEY (promocode_id) REFERENCES promocode (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE promocode_user ADD CONSTRAINT FK_35AF9D73A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_A45BDDC12130303A FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_A45BDDC129F6EE60 FOREIGN KEY (house_id) REFERENCES house (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user"  ADD CONSTRAINT FK_A45BDDC12130313A FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE promocode_user DROP CONSTRAINT FK_35AF9D73EF1A9D84');
        $this->addSql('ALTER TABLE promocode_user DROP CONSTRAINT FK_35AF9D73A76ED395');
        $this->addSql('ALTER TABLE address DROP CONSTRAINT FK_A45BDDC12130303A');
        $this->addSql('ALTER TABLE address DROP CONSTRAINT FK_A45BDDC129F6EE60');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_A45BDDC12130313A');
        $this->addSql('DROP SEQUENCE promocode_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE address_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "house_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "city_id_seq" CASCADE');
        $this->addSql('DROP TABLE promocode');
        $this->addSql('DROP TABLE promocode_user');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE house');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE "user"');
    }
}
