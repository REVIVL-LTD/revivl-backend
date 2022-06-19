<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220617124747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promocode ADD promo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE promocode ADD CONSTRAINT FK_7C786E06D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7C786E06D0C07AFF ON promocode (promo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE promocode DROP CONSTRAINT FK_7C786E06D0C07AFF');
        $this->addSql('DROP INDEX IDX_7C786E06D0C07AFF');
        $this->addSql('ALTER TABLE promocode DROP promo_id');
    }
}
