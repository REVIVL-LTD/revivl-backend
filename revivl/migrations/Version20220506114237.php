<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220506114237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE address_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE city_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE course_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE house_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE promocode_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE address (id INT NOT NULL, city_id INT DEFAULT NULL, street_house_id INT DEFAULT NULL, index VARCHAR(255) DEFAULT NULL, flat VARCHAR(5) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D4E6F818BAC62AF ON address (city_id)');
        $this->addSql('CREATE INDEX IDX_D4E6F81243756F8 ON address (street_house_id)');
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE city (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE course (id INT NOT NULL, doctor_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, cost INT NOT NULL, photo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_169E6FB987F4FB17 ON course (doctor_id)');
        $this->addSql('CREATE TABLE doctor (id INT NOT NULL, surname VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, sex BOOLEAN NOT NULL, photo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE house (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE patient (id INT NOT NULL, address_id INT DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, surname VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, sex BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1ADAD7EBF5B7AF75 ON patient (address_id)');
        $this->addSql('CREATE TABLE patient_course (patient_id INT NOT NULL, course_id INT NOT NULL, PRIMARY KEY(patient_id, course_id))');
        $this->addSql('CREATE INDEX IDX_1DD086436B899279 ON patient_course (patient_id)');
        $this->addSql('CREATE INDEX IDX_1DD08643591CC992 ON patient_course (course_id)');
        $this->addSql('CREATE TABLE promocode (id INT NOT NULL, name VARCHAR(255) NOT NULL, status INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE promocode_abstract_user (promocode_id INT NOT NULL, abstract_user_id INT NOT NULL, PRIMARY KEY(promocode_id, abstract_user_id))');
        $this->addSql('CREATE INDEX IDX_B8E4F00C76C06D9 ON promocode_abstract_user (promocode_id)');
        $this->addSql('CREATE INDEX IDX_B8E4F005D9B505 ON promocode_abstract_user (abstract_user_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, status INT NOT NULL, type INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F818BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81243756F8 FOREIGN KEY (street_house_id) REFERENCES house (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB987F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE doctor ADD CONSTRAINT FK_1FC0F36ABF396750 FOREIGN KEY (id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBBF396750 FOREIGN KEY (id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE patient_course ADD CONSTRAINT FK_1DD086436B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE patient_course ADD CONSTRAINT FK_1DD08643591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE promocode_abstract_user ADD CONSTRAINT FK_B8E4F00C76C06D9 FOREIGN KEY (promocode_id) REFERENCES promocode (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE promocode_abstract_user ADD CONSTRAINT FK_B8E4F005D9B505 FOREIGN KEY (abstract_user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE patient DROP CONSTRAINT FK_1ADAD7EBF5B7AF75');
        $this->addSql('ALTER TABLE address DROP CONSTRAINT FK_D4E6F818BAC62AF');
        $this->addSql('ALTER TABLE patient_course DROP CONSTRAINT FK_1DD08643591CC992');
        $this->addSql('ALTER TABLE course DROP CONSTRAINT FK_169E6FB987F4FB17');
        $this->addSql('ALTER TABLE address DROP CONSTRAINT FK_D4E6F81243756F8');
        $this->addSql('ALTER TABLE patient_course DROP CONSTRAINT FK_1DD086436B899279');
        $this->addSql('ALTER TABLE promocode_abstract_user DROP CONSTRAINT FK_B8E4F00C76C06D9');
        $this->addSql('ALTER TABLE admin DROP CONSTRAINT FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE doctor DROP CONSTRAINT FK_1FC0F36ABF396750');
        $this->addSql('ALTER TABLE patient DROP CONSTRAINT FK_1ADAD7EBBF396750');
        $this->addSql('ALTER TABLE promocode_abstract_user DROP CONSTRAINT FK_B8E4F005D9B505');
        $this->addSql('DROP SEQUENCE address_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE city_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE course_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE house_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE promocode_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE doctor');
        $this->addSql('DROP TABLE house');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE patient_course');
        $this->addSql('DROP TABLE promocode');
        $this->addSql('DROP TABLE promocode_abstract_user');
        $this->addSql('DROP TABLE "user"');
    }
}
