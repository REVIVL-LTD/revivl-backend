<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220614205647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promocode_abstract_user DROP CONSTRAINT fk_b8e4f00c76c06d9');
        $this->addSql('DROP SEQUENCE promocode_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE promo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE promo (id INT NOT NULL, name VARCHAR(255) NOT NULL, status INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE promo_abstract_user (promo_id INT NOT NULL, abstract_user_id INT NOT NULL, PRIMARY KEY(promo_id, abstract_user_id))');
        $this->addSql('CREATE INDEX IDX_FD3C2648D0C07AFF ON promo_abstract_user (promo_id)');
        $this->addSql('CREATE INDEX IDX_FD3C26485D9B505 ON promo_abstract_user (abstract_user_id)');
        $this->addSql('ALTER TABLE promo_abstract_user ADD CONSTRAINT FK_FD3C2648D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE promo_abstract_user ADD CONSTRAINT FK_FD3C26485D9B505 FOREIGN KEY (abstract_user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE promocode');
        $this->addSql('DROP TABLE promocode_abstract_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE promo_abstract_user DROP CONSTRAINT FK_FD3C2648D0C07AFF');
        $this->addSql('DROP SEQUENCE promo_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE promocode_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE promocode (id INT NOT NULL, name VARCHAR(255) NOT NULL, status INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE promocode_abstract_user (promocode_id INT NOT NULL, abstract_user_id INT NOT NULL, PRIMARY KEY(promocode_id, abstract_user_id))');
        $this->addSql('CREATE INDEX idx_b8e4f005d9b505 ON promocode_abstract_user (abstract_user_id)');
        $this->addSql('CREATE INDEX idx_b8e4f00c76c06d9 ON promocode_abstract_user (promocode_id)');
        $this->addSql('ALTER TABLE promocode_abstract_user ADD CONSTRAINT fk_b8e4f00c76c06d9 FOREIGN KEY (promocode_id) REFERENCES promocode (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE promocode_abstract_user ADD CONSTRAINT fk_b8e4f005d9b505 FOREIGN KEY (abstract_user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE promo');
        $this->addSql('DROP TABLE promo_abstract_user');
    }
}
