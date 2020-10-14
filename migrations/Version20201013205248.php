<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201013205248 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_answer_question (user_answer_id INT NOT NULL, question_id INT NOT NULL, INDEX IDX_836124A4AAD3C5E3 (user_answer_id), INDEX IDX_836124A41E27F6BF (question_id), PRIMARY KEY(user_answer_id, question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_answer_question ADD CONSTRAINT FK_836124A4AAD3C5E3 FOREIGN KEY (user_answer_id) REFERENCES user_answer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_answer_question ADD CONSTRAINT FK_836124A41E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_answer_question');
    }
}