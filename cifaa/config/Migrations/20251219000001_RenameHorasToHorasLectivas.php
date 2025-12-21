<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class RenameHorasToHorasLectivas extends AbstractMigration
{
    /**
     * Change Method.
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('certificados');
        
        // Renombrar horas a horas_lectivas si existe
        if ($table->hasColumn('horas')) {
            $table->renameColumn('horas', 'horas_lectivas');
        }
        
        $table->update();
    }
}
