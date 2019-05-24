<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190524090756 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE assoc_allergen (assoc_id INT NOT NULL, allergen_id INT NOT NULL, INDEX IDX_8009D05B82A46EC6 (assoc_id), INDEX IDX_8009D05B6E775A4A (allergen_id), PRIMARY KEY(assoc_id, allergen_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assoc_allergen ADD CONSTRAINT FK_8009D05B82A46EC6 FOREIGN KEY (assoc_id) REFERENCES assoc (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assoc_allergen ADD CONSTRAINT FK_8009D05B6E775A4A FOREIGN KEY (allergen_id) REFERENCES allergen (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE assoc_allergen');
    }
}
