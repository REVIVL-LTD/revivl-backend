<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601225236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE order_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "order" (id INT NOT NULL, status INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE code_auth ADD patient_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE code_auth DROP email');
        $this->addSql('ALTER TABLE code_auth ADD CONSTRAINT FK_CE35DA986B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_CE35DA986B899279 ON code_auth (patient_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE order_id_seq CASCADE');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('ALTER TABLE code_auth DROP CONSTRAINT FK_CE35DA986B899279');
        $this->addSql('DROP INDEX IDX_CE35DA986B899279');
        $this->addSql('ALTER TABLE code_auth ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE code_auth DROP patient_id');
    }
}
