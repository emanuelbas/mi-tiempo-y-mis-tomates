<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181202140735 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE client_applications_configuration (id INT AUTO_INCREMENT NOT NULL, application_id INT NOT NULL, category_id INT NOT NULL, client_id INT DEFAULT NULL, INDEX IDX_3A385F4E3E030ACD (application_id), INDEX IDX_3A385F4E12469DE2 (category_id), INDEX IDX_3A385F4E19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client_category_configuration (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, category_id INT NOT NULL, productivity_level_id INT NOT NULL, INDEX IDX_896B191419EB6921 (client_id), INDEX IDX_896B191412469DE2 (category_id), INDEX IDX_896B1914FAB835F8 (productivity_level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client_applications_configuration ADD CONSTRAINT FK_3A385F4E3E030ACD FOREIGN KEY (application_id) REFERENCES application (id)');
        $this->addSql('ALTER TABLE client_applications_configuration ADD CONSTRAINT FK_3A385F4E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE client_applications_configuration ADD CONSTRAINT FK_3A385F4E19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE client_category_configuration ADD CONSTRAINT FK_896B191419EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE client_category_configuration ADD CONSTRAINT FK_896B191412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE client_category_configuration ADD CONSTRAINT FK_896B1914FAB835F8 FOREIGN KEY (productivity_level_id) REFERENCES productivity_level (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE client_applications_configuration');
        $this->addSql('DROP TABLE client_category_configuration');
    }
}
