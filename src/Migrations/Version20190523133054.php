<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190523133054 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE commandassoc (id INT AUTO_INCREMENT NOT NULL, assoc_id INT NOT NULL, command_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_871CE98782A46EC6 (assoc_id), INDEX IDX_871CE98733E1689A (command_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commandassoc ADD CONSTRAINT FK_871CE98782A46EC6 FOREIGN KEY (assoc_id) REFERENCES assoc (id)');
        $this->addSql('ALTER TABLE commandassoc ADD CONSTRAINT FK_871CE98733E1689A FOREIGN KEY (command_id) REFERENCES command (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE commandassoc');
    }
}
