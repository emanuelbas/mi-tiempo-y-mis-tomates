<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181202021515 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client_uses_application ADD task_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client_uses_application ADD CONSTRAINT FK_F41F482A8DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('CREATE INDEX IDX_F41F482A8DB60186 ON client_uses_application (task_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client_uses_application DROP FOREIGN KEY FK_F41F482A8DB60186');
        $this->addSql('DROP INDEX IDX_F41F482A8DB60186 ON client_uses_application');
        $this->addSql('ALTER TABLE client_uses_application DROP task_id');
    }
}
