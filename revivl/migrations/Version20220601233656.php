<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601233656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doctor ALTER surname DROP NOT NULL');
        $this->addSql('ALTER TABLE doctor ALTER name DROP NOT NULL');
        $this->addSql('ALTER TABLE doctor ALTER sex DROP NOT NULL');
        $this->addSql('ALTER TABLE patient ALTER phone DROP NOT NULL');
        $this->addSql('ALTER TABLE patient ALTER birthday DROP NOT NULL');
        $this->addSql('ALTER TABLE patient ALTER surname DROP NOT NULL');
        $this->addSql('ALTER TABLE patient ALTER name DROP NOT NULL');
        $this->addSql('ALTER TABLE patient ALTER sex DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE doctor ALTER surname SET NOT NULL');
        $this->addSql('ALTER TABLE doctor ALTER name SET NOT NULL');
        $this->addSql('ALTER TABLE doctor ALTER sex SET NOT NULL');
        $this->addSql('ALTER TABLE patient ALTER phone SET NOT NULL');
        $this->addSql('ALTER TABLE patient ALTER birthday SET NOT NULL');
        $this->addSql('ALTER TABLE patient ALTER surname SET NOT NULL');
        $this->addSql('ALTER TABLE patient ALTER name SET NOT NULL');
        $this->addSql('ALTER TABLE patient ALTER sex SET NOT NULL');
    }
}
