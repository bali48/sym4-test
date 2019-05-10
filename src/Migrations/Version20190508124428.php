<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190508124428 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ticket CHANGE createdat createdat DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA31A6743D8 FOREIGN KEY (statusid_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_97A0ADA31A6743D8 ON ticket (statusid_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_97A0ADA3AE80F5DF ON ticket (department_id)');
        $this->addSql('ALTER TABLE user CHANGE createdat createdat DATETIME DEFAULT NULL, CHANGE updatedat updatedat DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA31A6743D8');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3AE80F5DF');
        $this->addSql('DROP INDEX UNIQ_97A0ADA31A6743D8 ON ticket');
        $this->addSql('DROP INDEX UNIQ_97A0ADA3AE80F5DF ON ticket');
        $this->addSql('ALTER TABLE ticket CHANGE createdat createdat DATETIME DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE user CHANGE createdat createdat DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE updatedat updatedat DATETIME DEFAULT CURRENT_TIMESTAMP');
    }
}
