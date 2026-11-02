<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Models\SchSetting getSchoolSettings()
 * @method static \App\Models\SchoolSession getActiveSession()
 * @method static ?int getActiveSessionId()
 * @method static array getSessionList()
 * @method static array getLanguageList()
 * @method static array getCurrencyList()
 * @method static string getSchoolLogo()
 * @method static string getSidebarImage()
 * @method static string formatCurrency(float $amount)
 * @method static string formatDate($date, ?string $format = null)
 * @method static string formatTime($time)
 * @method static ?\App\Models\StudentSession getStudentSession(int $studentId, int $sessionId)
 * @method static ?\App\Models\StudentSession getStudentCurrentSession(int $studentId)
 * @method static array getClasses()
 * @method static array getSectionsByClass(int $classId)
 * @method static string generateRollNumber(int $classId, int $sessionId)
 * @method static string generateAdmissionNo()
 * @method static string generateInvoiceNumber(string $prefix = 'INV')
 * @method static string uploadFile($file, string $path, string $prefix = 'FILE')
 * @method static bool deleteFile(?string $path)
 * @method static string resizeImage(string $source, int $width = 200, int $height = 200, bool $keepAspect = true)
 * @method static string formatBytes(int $bytes, int $precision = 2)
 * @method static ?string getUserRole()
 * @method static string getAcademicYearFromDate(\DateTimeInterface $date)
 */
class Customlib extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \App\Services\Customlib::class;
    }
}
