<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201025173334 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer ADD weight SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE question RENAME INDEX idx_b6f7494e12469de2 TO IDX_B6F7494E853CD175');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer DROP weight');
        $this->addSql('ALTER TABLE question RENAME INDEX idx_b6f7494e853cd175 TO IDX_B6F7494E12469DE2');
    }
}
