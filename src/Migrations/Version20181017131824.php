<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181017131824 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE application (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, app_id INT NOT NULL, app_name VARCHAR(255) NOT NULL, INDEX IDX_A45BDDC112469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, productivity_level_id INT DEFAULT NULL, category_name VARCHAR(255) NOT NULL, INDEX IDX_64C19C1FAB835F8 (productivity_level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
		$this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, secret_question_id INT DEFAULT NULL, report_frequency_id INT DEFAULT NULL, pomodoros_configuration_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, secret_answer VARCHAR(255) NOT NULL, INDEX IDX_C744045534911AD5 (secret_question_id), INDEX IDX_C74404559AED00BB (report_frequency_id), UNIQUE INDEX UNIQ_C744045518828175 (pomodoros_configuration_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client_uses_application (id INT AUTO_INCREMENT NOT NULL, application_id INT DEFAULT NULL, client_id INT DEFAULT NULL, start_date DATETIME NOT NULL, time_ammount INT DEFAULT NULL, INDEX IDX_F41F482A3E030ACD (application_id), INDEX IDX_F41F482A19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pomodoro (id INT AUTO_INCREMENT NOT NULL, task_id INT DEFAULT NULL, start_date DATETIME NOT NULL, ending_date DATETIME NOT NULL, INDEX IDX_2C4F05198DB60186 (task_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pomodoros_configuration (id INT AUTO_INCREMENT NOT NULL,client_id INT DEFAULT NULL, break_time INT NOT NULL, working_time INT NOT NULL, end_break_alarm TINYINT(1) NOT NULL, end_work_alarm TINYINT(1) NOT NULL, clock_sound TINYINT(1) NOT NULL,INDEX IDX_527EDB2519EB6923 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE productivity_level (id INT AUTO_INCREMENT NOT NULL, level_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE report_frequency (id INT AUTO_INCREMENT NOT NULL, frequency_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE secret_question (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, task_state_id INT DEFAULT NULL, task_name VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, stimated_pomodoros INT NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_527EDB2519EB6921 (client_id), INDEX IDX_527EDB254518D68D (task_state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_state (id INT AUTO_INCREMENT NOT NULL, state VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1FAB835F8 FOREIGN KEY (productivity_level_id) REFERENCES productivity_level (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045534911AD5 FOREIGN KEY (secret_question_id) REFERENCES secret_question (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404559AED00BB FOREIGN KEY (report_frequency_id) REFERENCES report_frequency (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045518828175 FOREIGN KEY (pomodoros_configuration_id) REFERENCES pomodoros_configuration (id)');
        $this->addSql('ALTER TABLE client_uses_application ADD CONSTRAINT FK_F41F482A3E030ACD FOREIGN KEY (application_id) REFERENCES application (id)');
        $this->addSql('ALTER TABLE client_uses_application ADD CONSTRAINT FK_F41F482A19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE pomodoro ADD CONSTRAINT FK_2C4F05198DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB2519EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB254518D68D FOREIGN KEY (task_state_id) REFERENCES task_state (id)');
        $this->addSql('ALTER TABLE pomodoros_configuration ADD CONSTRAINT FK_F41F482A19EB6923 FOREIGN KEY (client_id) REFERENCES client (id)');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
/*        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client_uses_application DROP FOREIGN KEY FK_F41F482A3E030ACD');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC112469DE2');
        $this->addSql('ALTER TABLE client_uses_application DROP FOREIGN KEY FK_F41F482A19EB6921');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB2519EB6921');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045518828175');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1FAB835F8');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404559AED00BB');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045534911AD5');
        $this->addSql('ALTER TABLE pomodoro DROP FOREIGN KEY FK_2C4F05198DB60186');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB254518D68D');
        $this->addSql('DROP TABLE application');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE client_uses_application');
        $this->addSql('DROP TABLE pomodoro');
        $this->addSql('DROP TABLE pomodoros_configuration');
        $this->addSql('DROP TABLE productivity_level');
        $this->addSql('DROP TABLE report_frequency');
        $this->addSql('DROP TABLE secret_question');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE task_state');*/
    }
}
