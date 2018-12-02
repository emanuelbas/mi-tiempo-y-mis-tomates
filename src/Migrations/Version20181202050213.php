<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181202050213 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC112469DE2');
        $this->addSql('DROP INDEX IDX_A45BDDC112469DE2 ON application');
        $this->addSql('ALTER TABLE application DROP category_id');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1FAB835F8');
        $this->addSql('DROP INDEX IDX_64C19C1FAB835F8 ON category');
        $this->addSql('ALTER TABLE category DROP productivity_level_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE application ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC112469DE2 ON application (category_id)');
        $this->addSql('ALTER TABLE category ADD productivity_level_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1FAB835F8 FOREIGN KEY (productivity_level_id) REFERENCES productivity_level (id)');
        $this->addSql('CREATE INDEX IDX_64C19C1FAB835F8 ON category (productivity_level_id)');
    }
}
