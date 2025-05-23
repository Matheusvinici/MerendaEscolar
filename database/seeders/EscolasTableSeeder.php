<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EscolasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Desativa a verificação de chaves estrangeiras temporariamente
         DB::statement('SET FOREIGN_KEY_CHECKS=0;');
         DB::table('escolas')->truncate();
         DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // Lista de escolas
        $escolas = [
            ['nome' => '02 DE JULHO', 'codigo_inep' => 'ESC001'],
            ['nome' => '15 DE JULHO', 'codigo_inep' => 'ESC002'],
            ['nome' => '25 DE JULHO', 'codigo_inep' => 'ESC003'],
            ['nome' => 'AMÉRICO TANURI - JUNCO', 'codigo_inep' => 'ESC004'],
            ['nome' => 'AMÉRICO TANURI - MANIÇOBA', 'codigo_inep' => 'ESC005'],
            ['nome' => 'ANÁLIA BARBOSA DE SOUZA', 'codigo_inep' => 'ESC006'],
            ['nome' => 'ANTONIO FRANCISCO DE OLIVEIRA', 'codigo_inep' => 'ESC007'],
            ['nome' => 'ARGEMIRO JOSE DA CRUZ', 'codigo_inep' => 'ESC008'],
            ['nome' => 'BOM JESUS - BARAÚNA', 'codigo_inep' => 'ESC009'],
            ['nome' => 'BOM JESUS - NH1', 'codigo_inep' => 'ESC010'],
            ['nome' => 'C.R.A. PROFª MAZZARELLO CAVALCANTI REIS DA ROCHA', 'codigo_inep' => 'ESC011'],
            ['nome' => 'CAIC - MISAEL AGUILAR', 'codigo_inep' => 'ESC012'],
            ['nome' => 'CAXANGÁ', 'codigo_inep' => 'ESC013'],
            ['nome' => 'CELSO CAVALCANTE DE CARVALHO', 'codigo_inep' => 'ESC014'],
            ['nome' => 'CENTRO SOCIAL URBANO - CSU', 'codigo_inep' => 'ESC015'],
            ['nome' => 'CORAÇÃO DE JESUS - JUREMA VERMELHA', 'codigo_inep' => 'ESC016'],
            ['nome' => 'CORAÇÃO DE JESUS - SERRA DA MADEIRA', 'codigo_inep' => 'ESC017'],
            ['nome' => 'DEPUTADO RAIMUNDO DA CUNHA LEITE', 'codigo_inep' => 'ESC018'],
            ['nome' => 'DOM AVELAR BRANDAO VILELA', 'codigo_inep' => 'ESC019'],
            ['nome' => 'DOUTOR EDSON RIBEIRO', 'codigo_inep' => 'ESC020'],
            ['nome' => 'DURVAL BARBOSA DA CUNHA', 'codigo_inep' => 'ESC021'],
            ['nome' => 'E.M.E.I. ADELAIDE MOREIRA BISPO', 'codigo_inep' => 'ESC022'],
            ['nome' => 'E.M.E.I. ADJALVA FERREIRA LIMA', 'codigo_inep' => 'ESC023'],
            ['nome' => 'E.M.E.I. AMÉLIA BORGES', 'codigo_inep' => 'ESC024'],
            ['nome' => 'E.M.E.I. AMÉLIA DUARTE', 'codigo_inep' => 'ESC025'],
            ['nome' => 'E.M.E.I. AMÉRICO TANURY - ABÓBORA', 'codigo_inep' => 'ESC026'],
            ['nome' => 'E.M.E.I. ANA MARIA MORGADO CHAVES', 'codigo_inep' => 'ESC027'],
            ['nome' => 'E.M.E.I. ANNA HILDA LEITE FARIAS', 'codigo_inep' => 'ESC028'],
            ['nome' => 'E.M.E.I. ARCENIO JOSÉ DA SILVA', 'codigo_inep' => 'ESC029'],
            ['nome' => 'E.M.E.I. ARLINDA ALVES VARJÃO', 'codigo_inep' => 'ESC030'],
            ['nome' => 'E.M.E.I. BEATRIZ ANGÉLICA MOTA', 'codigo_inep' => 'ESC031'],
            ['nome' => 'E.M.E.I. BOLIVAR SANTANA', 'codigo_inep' => 'ESC032'],
            ['nome' => 'E.M.E.I. BOM JESUS DOS NAVEGANTES', 'codigo_inep' => 'ESC033'],
            ['nome' => 'E.M.E.I. CAIC MISAEL AGUILAR', 'codigo_inep' => 'ESC034'],
            ['nome' => 'E.M.E.I. DILMA CALMON DE OLIVEIRA', 'codigo_inep' => 'ESC035'],
            ['nome' => 'E.M.E.I. EDIVÂNIA SANTOS CARDOSO', 'codigo_inep' => 'ESC036'],
            ['nome' => 'E.M.E.I. ELEOTÉRIO SOUZA', 'codigo_inep' => 'ESC037'],
            ['nome' => 'E.M.E.I. FRANCISCO PEREIRA DOS SANTOS', 'codigo_inep' => 'ESC038'],
            ['nome' => 'E.M.E.I. GABRIELA DE JESUS', 'codigo_inep' => 'ESC039'],
            ['nome' => 'E.M.E.I. IRMÃ ADILSON', 'codigo_inep' => 'ESC040'],
            ['nome' => 'E.M.E.I. IRMÃO ADEÍLSON', 'codigo_inep' => 'ESC041'],
            ['nome' => 'E.M.E.I. LÍDIA MARIA NOGUEIRA', 'codigo_inep' => 'ESC042'],
            ['nome' => 'E.M.E.I. LUIZ DE FREITAS', 'codigo_inep' => 'ESC043'],
            ['nome' => 'E.M.E.I. MARIA HELENA DA SILVA PEREIRA', 'codigo_inep' => 'ESC044'],
            ['nome' => 'E.M.E.I. MARIA HOZANA NUNES', 'codigo_inep' => 'ESC045'],
            ['nome' => 'E.M.E.I. MARIA JÚLIA RODRIGUES TANURI', 'codigo_inep' => 'ESC046'],
            ['nome' => 'E.M.E.I. MARIA SUELY MEDRADO ARAÚJO', 'codigo_inep' => 'ESC047'],
            ['nome' => 'E.M.E.I. MARIÁ VIANA TANURI', 'codigo_inep' => 'ESC048'],
            ['nome' => 'E.M.E.I. NAILDE DE SOUZA COSTA', 'codigo_inep' => 'ESC049'],
            ['nome' => 'E.M.E.I. NÉLIA DE SOUZA COSTA', 'codigo_inep' => 'ESC050'],
            ['nome' => 'E.M.E.I. NOSSA SENHORA DAS GROTAS - CARNAÍBA', 'codigo_inep' => 'ESC051'],
            ['nome' => 'E.M.E.I. NOSSO SENHOR DOS AFLITOS', 'codigo_inep' => 'ESC052'],
            ['nome' => 'E.M.E.I. PASSAGEM DO SARGENTO', 'codigo_inep' => 'ESC053'],
            ['nome' => 'E.M.E.I. PASTOR MANOEL MARQUES DE SOUZA', 'codigo_inep' => 'ESC054'],
            ['nome' => 'E.M.E.I. PREFEITO APRÍGIO DUARTE', 'codigo_inep' => 'ESC055'],
            ['nome' => 'E.M.E.I. PROFª HELOISA HELENA BENEVIDES FARIAS', 'codigo_inep' => 'ESC056'],
            ['nome' => 'E.M.E.I. PROFª JOANA RAMOS', 'codigo_inep' => 'ESC057'],
            ['nome' => 'E.M.E.I. VANDA GUERRA', 'codigo_inep' => 'ESC058'],
            ['nome' => 'E.M.R.T.I. SÃO JOSÉ', 'codigo_inep' => 'ESC059'],
            ['nome' => 'E.M.T.I. PROFª IRACEMA PEREIRA DA PAIXÃO', 'codigo_inep' => 'ESC060'],
            ['nome' => 'EDUCANDÁRIO JOÃO XXIII', 'codigo_inep' => 'ESC061'],
            ['nome' => 'ELISEU SANTOS', 'codigo_inep' => 'ESC062'],
            ['nome' => 'ESTAÇÃO DO SABER JOSÉ CARLOS TANURI', 'codigo_inep' => 'ESC063'],
            ['nome' => 'EURÍDICE RIBEIRO VIANA', 'codigo_inep' => 'ESC064'],
            ['nome' => 'EXTENSAO - BOLIVAR SANTANA', 'codigo_inep' => 'ESC065'],
            ['nome' => 'EXTENSAO - E.M.E.I. GENTIL DAMASIO DO NASCIMENTO', 'codigo_inep' => 'ESC066'],
            ['nome' => 'EXTENSAO - E.M.E.I. MARIA VIANA TANURI', 'codigo_inep' => 'ESC067'],
            ['nome' => 'EXTENSAO - MARIA MONTEIRO BACELAR', 'codigo_inep' => 'ESC068'],
            ['nome' => 'EXTENSAO - PRESIDENTE TANCREDO NEVES', 'codigo_inep' => 'ESC069'],
            ['nome' => 'FAMÍLIA UNIDA', 'codigo_inep' => 'ESC070'],
            ['nome' => 'GRACIOSA XAVIER RAMOS GOMES', 'codigo_inep' => 'ESC071'],
            ['nome' => 'HELENA ARAÚJO PINHEIRO', 'codigo_inep' => 'ESC072'],
            ['nome' => 'HELENA CELESTINO MAGALHÃES', 'codigo_inep' => 'ESC073'],
            ['nome' => 'JATOBÁ', 'codigo_inep' => 'ESC074'],
            ['nome' => 'JOÃO DIAS FERREIRA', 'codigo_inep' => 'ESC075'],
            ['nome' => 'JOÃO NEVES DE ALMEIDA', 'codigo_inep' => 'ESC076'],
            ['nome' => 'JOCA DE SOUZA OLIVEIRA', 'codigo_inep' => 'ESC077'],
            ['nome' => 'JOSÉ DE AMORIM', 'codigo_inep' => 'ESC078'],
            ['nome' => 'JOSÉ DIAS CAVALCANTE', 'codigo_inep' => 'ESC079'],
            ['nome' => 'JOSÉ MACÊDO DE ARAÚJO', 'codigo_inep' => 'ESC080'],
            ['nome' => 'JOSÉ NOGUEIRA DE ALMEIDA', 'codigo_inep' => 'ESC081'],
            ['nome' => 'JOSÉ RAMOS BORGES', 'codigo_inep' => 'ESC082'],
            ['nome' => 'LUIZ EDUARDO RODRIGUES', 'codigo_inep' => 'ESC083'],
            ['nome' => 'MARCÍLIO JOSÉ DE SOUZA', 'codigo_inep' => 'ESC084'],
            ['nome' => 'MARIA JOSÉ FARIAS', 'codigo_inep' => 'ESC085'],
            ['nome' => 'MARIA JOSÉ SILVA DE ARAÚJO', 'codigo_inep' => 'ESC086'],
            ['nome' => 'MARIA LUIZA ARAÚJO', 'codigo_inep' => 'ESC087'],
            ['nome' => 'MARIA MONTEIRO BACELAR', 'codigo_inep' => 'ESC088'],
            ['nome' => 'MARIANA DE SOUZA PEREIRA', 'codigo_inep' => 'ESC089'],
            ['nome' => 'MARIZETE ARAÚJO DO NASCIMENTO', 'codigo_inep' => 'ESC090'],
            ['nome' => 'MATINHA DE ALMEIDA', 'codigo_inep' => 'ESC091'],
            ['nome' => 'MERCÊS RAMOS DE SOUZA', 'codigo_inep' => 'ESC092'],
            ['nome' => 'MARIA JULIA RODRIGUES TANURI', 'codigo_inep' => 'ESC093'],
            ['nome' => 'MARIA MONTEIRO BACELAR', 'codigo_inep' => 'ESC094'],
            ['nome' => 'MARIANO RODRIGUES DE SOUZA', 'codigo_inep' => 'ESC095'],
            ['nome' => 'MIGUEL ÂNGELO DE SOUZA', 'codigo_inep' => 'ESC096'],
            ['nome' => 'NOSSA SENHORA DAS GROTAS - BOQUEIRÃO', 'codigo_inep' => 'ESC097'],
            ['nome' => 'NOSSA SENHORA DAS GROTAS-SEDE', 'codigo_inep' => 'ESC098'],
            ['nome' => 'NOSSA SENHORA RAINHA DOS ANJOS', 'codigo_inep' => 'ESC099'],
            ['nome' => 'OSORIO TELES DE MENEZES', 'codigo_inep' => 'ESC100'],
            ['nome' => 'PAULO FREIRE', 'codigo_inep' => 'ESC101'],
            ['nome' => 'PAULO VI', 'codigo_inep' => 'ESC102'],
            ['nome' => 'PEDRO DIAS', 'codigo_inep' => 'ESC103'],
            ['nome' => 'PONTAL', 'codigo_inep' => 'ESC104'],
            ['nome' => 'PREFEITO APRÍGIO DUARTE', 'codigo_inep' => 'ESC105'],
            ['nome' => 'PRESIDENTE TANCREDO NEVES', 'codigo_inep' => 'ESC106'],
            ['nome' => 'PROFª ANTONILA DA FRANÇA CARDOSO', 'codigo_inep' => 'ESC107'],
            ['nome' => 'PROFª ATANILHA LUZ ARAÚJO', 'codigo_inep' => 'ESC108'],
            ['nome' => 'PROFª BERNADETE BRAGA', 'codigo_inep' => 'ESC109'],
            ['nome' => 'PROFª CARMEM COSTA SANTOS', 'codigo_inep' => 'ESC110'],
            ['nome' => 'PROFª CRENILDES LUIZ BRANDÃO', 'codigo_inep' => 'ESC111'],
            ['nome' => 'PROFª DINORAH ALBERNAZ MELO DA SILVA', 'codigo_inep' => 'ESC112'],
            ['nome' => 'PROFª EDUALDINA DAMÁSIO', 'codigo_inep' => 'ESC113'],
            ['nome' => 'PROFª GUIOMAR LUSTOSA RODRIGUES', 'codigo_inep' => 'ESC114'],
            ['nome' => 'PROFª HAYDÉE FONSECA FALCÃO', 'codigo_inep' => 'ESC115'],
            ['nome' => 'PROFª IRACY NUNES DA SILVA', 'codigo_inep' => 'ESC116'],
            ['nome' => 'PROFª LEOPOLDINA LEAL', 'codigo_inep' => 'ESC117'],
            ['nome' => 'PROFª MARIA DE LOURDES DUARTE', 'codigo_inep' => 'ESC118'],
            ['nome' => 'PROFª MARIA FRANCA PIRES', 'codigo_inep' => 'ESC119'],
            ['nome' => 'PROFª MARIA JOSÉ LIMA DA ROCHA', 'codigo_inep' => 'ESC120'],
            ['nome' => 'PROFª MATILDE COSTA MEDRADO', 'codigo_inep' => 'ESC121'],
            ['nome' => 'PROFª OSCARLINA TANURI', 'codigo_inep' => 'ESC122'],
            ['nome' => 'PROFª TEREZINHA FERREIRA DE OLIVEIRA', 'codigo_inep' => 'ESC123'],
            ['nome' => 'PROFº CARLOS DA COSTA SILVA', 'codigo_inep' => 'ESC124'],
            ['nome' => 'PROFº JOSÉ PEREIRA DA SILVA', 'codigo_inep' => 'ESC125'],
            ['nome' => 'PROFº LUIS CURSINO DA FRANÇA CARDOSO', 'codigo_inep' => 'ESC126'],
            ['nome' => 'PROFº PEDRO RAIMUNDO RODRIGUES REGO', 'codigo_inep' => 'ESC127'],
            ['nome' => 'PROMENOR', 'codigo_inep' => 'ESC128'],
            ['nome' => 'RAIMUNDO CLEMENTINO DE SOUZA', 'codigo_inep' => 'ESC129'],
            ['nome' => 'RAIMUNDO MEDRADO PRIMO', 'codigo_inep' => 'ESC130'],
            ['nome' => 'RURAL DE MASSAROCA - ERUM', 'codigo_inep' => 'ESC131'],
            ['nome' => 'SANTA INÊS', 'codigo_inep' => 'ESC132'],
            ['nome' => 'SANTA TEREZINHA', 'codigo_inep' => 'ESC133'],
            ['nome' => 'SANTO ANTÔNIO', 'codigo_inep' => 'ESC134'],
            ['nome' => 'SÃO FRANCISCO DE ASSIS - MULUNGÚ', 'codigo_inep' => 'ESC135'],
            ['nome' => 'SÃO FRANCISCO DE ASSIS - NH2', 'codigo_inep' => 'ESC136'],
            ['nome' => 'SÃO JOSÉ', 'codigo_inep' => 'ESC137'],
            ['nome' => 'SÃO SEBASTIÃO', 'codigo_inep' => 'ESC138'],
            ['nome' => 'VEREADOR AMADEUS DAMÁSIO', 'codigo_inep' => 'ESC139'],
        ];

        // Inserir escolas no banco de dados
        DB::table('escolas')->insert($escolas);
    }
}