<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190523131237 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pricetype (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE priceassoc (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, assoc_id INT NOT NULL, value NUMERIC(5, 2) NOT NULL, INDEX IDX_5BE4B5B0C54C8C93 (type_id), INDEX IDX_5BE4B5B082A46EC6 (assoc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assoc (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, type_id INT DEFAULT NULL, quantity INT NOT NULL, is_dish TINYINT(1) NOT NULL, description LONGTEXT DEFAULT NULL, composition LONGTEXT DEFAULT NULL, INDEX IDX_7B9337114584665A (product_id), INDEX IDX_7B933711C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pricemenu (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, menu_id INT NOT NULL, value NUMERIC(5, 2) NOT NULL, INDEX IDX_650228E6C54C8C93 (type_id), INDEX IDX_650228E6CCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE command (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, INDEX IDX_8ECAEAD4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_midi TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_assoc (menu_id INT NOT NULL, assoc_id INT NOT NULL, INDEX IDX_EA3F1476CCD7E912 (menu_id), INDEX IDX_EA3F147682A46EC6 (assoc_id), PRIMARY KEY(menu_id, assoc_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE priceassoc ADD CONSTRAINT FK_5BE4B5B0C54C8C93 FOREIGN KEY (type_id) REFERENCES pricetype (id)');
        $this->addSql('ALTER TABLE priceassoc ADD CONSTRAINT FK_5BE4B5B082A46EC6 FOREIGN KEY (assoc_id) REFERENCES assoc (id)');
        $this->addSql('ALTER TABLE assoc ADD CONSTRAINT FK_7B9337114584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE assoc ADD CONSTRAINT FK_7B933711C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE pricemenu ADD CONSTRAINT FK_650228E6C54C8C93 FOREIGN KEY (type_id) REFERENCES pricetype (id)');
        $this->addSql('ALTER TABLE pricemenu ADD CONSTRAINT FK_650228E6CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD4A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE menu_assoc ADD CONSTRAINT FK_EA3F1476CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_assoc ADD CONSTRAINT FK_EA3F147682A46EC6 FOREIGN KEY (assoc_id) REFERENCES assoc (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE priceassoc DROP FOREIGN KEY FK_5BE4B5B0C54C8C93');
        $this->addSql('ALTER TABLE pricemenu DROP FOREIGN KEY FK_650228E6C54C8C93');
        $this->addSql('ALTER TABLE priceassoc DROP FOREIGN KEY FK_5BE4B5B082A46EC6');
        $this->addSql('ALTER TABLE menu_assoc DROP FOREIGN KEY FK_EA3F147682A46EC6');
        $this->addSql('ALTER TABLE assoc DROP FOREIGN KEY FK_7B933711C54C8C93');
        $this->addSql('ALTER TABLE assoc DROP FOREIGN KEY FK_7B9337114584665A');
        $this->addSql('ALTER TABLE pricemenu DROP FOREIGN KEY FK_650228E6CCD7E912');
        $this->addSql('ALTER TABLE menu_assoc DROP FOREIGN KEY FK_EA3F1476CCD7E912');
        $this->addSql('DROP TABLE pricetype');
        $this->addSql('DROP TABLE priceassoc');
        $this->addSql('DROP TABLE assoc');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE pricemenu');
        $this->addSql('DROP TABLE command');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_assoc');
    }
}
