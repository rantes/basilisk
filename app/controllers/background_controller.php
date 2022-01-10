<?php
/**
 * Tasks management in background.
 *
 * @author  Javier Serrano <jserrano@muy.co>
 * @version  1.0
 * @package MUYCCTV
 * @subpackage Controllers
 */
class BackgroundController extends Page {
    public $layout = false;
    public $noTemplate = [
        'index',
        'gettext',
        'serverdata'
    ];
    private $_colorMsg = null;
    public $shellOutput = true;

    public function __construct() {
        parent::__construct();
        class_exists('DumboShellColors') or require_once('DumboShellColors.php');
        $this->_colorMsg = new DumboShellColors();
    }

    private function _logger($source, $message) {
        if (empty($source) or empty($message) or !is_string($source) or !is_string($message)):
            return false;
        endif;
        $logdir = INST_PATH.'tmp/logs/';
        is_dir($logdir) or mkdir($logdir, 0775);
        $file = "{$source}.log";
        $stamp = date('d-m-Y H:i:s');

        file_exists("{$logdir}{$file}") and filesize("{$logdir}{$file}") >= 524288000 and rename("{$logdir}{$file}", "{$logdir}{$stamp}_{$file}");
        $this->shellOutput and fwrite(STDOUT, $this->_colorMsg->getColoredString($message, 'white', 'green') . "\n");
        file_put_contents("{$logdir}{$file}", "[{$stamp}] - {$message}\n", FILE_APPEND);
        return true;
    }

    private function _readFiles($path, $pattern) {
        $files = [];
        $dir = opendir($path);
        //first level, not subdirectories
        while(false !== ($file = readdir($dir))):
            $file !== '.' and $file !== '..' and is_file("{$path}{$file}") and preg_match($pattern, $file, $matches) === 1 and ($files[] = "{$path}{$file}");
        endwhile;
        closedir($dir);
        //Second level, subdirectories
        $dir = opendir($path);
        while(false !== ($file = readdir($dir))):
            $npath = "{$path}{$file}";
            if ($file !== '.' and $file !== '..' and is_dir($npath) and is_readable($npath)):
                $dir1 = opendir("{$path}{$file}");
                if(false !== $dir1):
                    while(false !== ($file1 = readdir($dir1))):
                        is_file("{$path}{$file}/{$file1}") and preg_match($pattern, $file1, $matches) === 1 and ($files[] = "{$path}{$file}/{$file1}");
                    endwhile;
                    closedir($dir1);
                endif;
            endif;
        endwhile;
        closedir($dir);
        sort($files);

        return $files;
    }

    public function gettextAction() {
        $files = array_merge(
            $this->_readFiles(INST_PATH.'app/', '/(.+)\.php/'),
            $this->_readFiles(INST_PATH.'app/views/', '/(.+)\.phtml/')
        );

        $tmpFile = tempnam('/tmp', 'gettext');
        file_put_contents($tmpFile, implode(PHP_EOL, $files));
        $languages = [
            'en_US' => 'English',
            'es_CO' => 'Spanish',
            'es_MX' => 'Spanish',
            'pt_BR' => 'Portuguese'
        ];
        $locales = [
            'en_US',
            'es_CO',
            'es_MX',
            'pt_BR'
        ];
        file_exists(INST_PATH.'locale') or mkdir(INST_PATH.'locale');
        while (null !== ($locale = array_shift($locales))):
            file_exists(INST_PATH."locale/{$locale}.utf8") or mkdir(INST_PATH."locale/{$locale}.utf8");
            file_exists(INST_PATH."locale/{$locale}.utf8/LC_MESSAGES") or mkdir(INST_PATH."locale/{$locale}.utf8/LC_MESSAGES");
            $srclangpo = INST_PATH."locale/{$locale}.po";
            exec("xgettext --language=PHP --sort-output --files-from={$tmpFile} -o {$srclangpo} > /dev/null 2>&1 ");
            $tgtlang = INST_PATH."locale/{$locale}.utf8/LC_MESSAGES/translations.po";
            file_exists($tgtlang) or copy($srclangpo, $tgtlang);
            exec("msgmerge --update {$tgtlang} {$srclangpo} > /dev/null 2>&1");
            unlink($srclangpo);

            $moHeader = <<<DUMBO
# LOCALE TRANSLATIONS FILE.
# FIRST AUTHOR Javier Serrano <javier@latuteca.com>, 2021.
#
#, fuzzy
msgid ""
msgstr ""
"Project-Id-Version: KOMODO-1.0\\n"
"Report-Msgid-Bugs-To: javier@latuteca.com\\n"
"POT-Creation-Date: 2020-05-08 03:01-0500\\n"
"PO-Revision-Date: YEAR-MO-DA HO:MI+ZONE\\n"
"Last-Translator: Javier Serrano <javier@latuteca.com>\\n"
"Language-Team: DEVELOPMENT <javier@latuteca.com>\\n"
"Language: {$languages[$locale]}\\n"
"MIME-Version: 1.0\\n"
"Content-Type: text/plain; charset=UTF-8\\n"
"Content-Transfer-Encoding: 8bit\\n"
\n
DUMBO;

            $fp = fopen($tgtlang, 'r');
            if($fp):
                while(false !== ($buffer = fgets($fp, 1024))):
                    if (preg_match('@^msgid[ ]{1}\"[a-zA-Z0-9.]+\"$@i', $buffer)) {
                        $id = trim(str_replace('"', '', str_replace('msgid ', '', $buffer)));
                        $str = trim(str_replace('"', '', str_replace('msgstr ', '', fgets($fp, 1024))));

                        $this->Translation->Find([
                            'first',
                            'conditions' => "`locale` = '{$locale}' AND `keyid` = '{$id}'"
                        ])->counter() === 0 and $this->Translation->Niu([
                            'locale' => $locale,
                            'translation' => $str,
                            'keyid' => $id
                        ])->Save();
                    }
                endwhile;
                fclose($fp);
            endif;

            file_put_contents($tgtlang, $moHeader);

            $translations = $this->Translation->Find_by_locale($locale)->getArray();
            while(null !== ($reg = array_shift($translations))):
                $ent = html_entity_decode($reg['translation'], ENT_QUOTES, 'UTF-8');
                $str = "msgid \"{$reg['keyid']}\"\nmsgstr \"{$ent}\"\n\n";
                file_put_contents($tgtlang, $str, FILE_APPEND);
            endwhile;
            $tgtlang = substr($tgtlang, 0, -2);
            exec("msgfmt --output-file={$tgtlang}mo {$tgtlang}po > /dev/null 2>&1");
        endwhile;
        unlink($tmpFile);
    }

}
