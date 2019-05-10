<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190509115828 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_97A0ADA3AE80F5DF ON ticket');
        $this->addSql('DROP INDEX UNIQ_97A0ADA31A6743D8 ON ticket');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_97A0ADA3AE80F5DF ON ticket (department_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_97A0ADA31A6743D8 ON ticket (statusid_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_97A0ADA31A6743D8 ON ticket');
        $this->addSql('DROP INDEX UNIQ_97A0ADA3AE80F5DF ON ticket');
        $this->addSql('CREATE INDEX UNIQ_97A0ADA31A6743D8 ON ticket (statusid_id)');
        $this->addSql('CREATE INDEX UNIQ_97A0ADA3AE80F5DF ON ticket (department_id)');
    }
}
