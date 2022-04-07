using System;
using System.IO;
using System.Xml;
using Excel = Microsoft.Office.Interop.Excel;

namespace XML_Converter {
    class Program {
        static void Main(string[] args) {
            string path = Path.Combine(Directory.GetCurrentDirectory(), "Lista_projektow_FE_2014_2020_030422.xlsx");

            Excel.Application xlApp = new Excel.Application();
            Excel.Workbook xlWorkbook = xlApp.Workbooks.Open(path);
            Excel._Worksheet xlWorksheet = xlWorkbook.Sheets[1];
            Excel.Range xlRange = xlWorksheet.UsedRange;

            int rowCount = xlRange.Rows.Count;
            int colCount = xlRange.Columns.Count;

            using (XmlWriter writer = XmlWriter.Create("Lista_projektow_FE_2014_2020_030422.xml"))
            {
                writer.WriteStartElement("lista_projektow");
                for (int i = 4; i <= rowCount; i++)
                {
                    for (int j = 1; j <= colCount; j++)
                    {
                        switch (j) {
                            case 1:
                                writer.WriteStartElement("dane_projektu");
                                writer.WriteStartElement("projekt");
                                writer.WriteElementString("tytul_projektu", xlRange.Cells[i, j].Value2.ToString());
                                break;
                            case 2:
                                writer.WriteElementString("skrocony_opis", xlRange.Cells[i, j].Value2.ToString());
                                break;
                            case 3:
                                writer.WriteElementString("numer_umowy", xlRange.Cells[i, j].Value2.ToString());
                                writer.WriteEndElement();
                                break;
                            case 4:
                                writer.WriteStartElement("beneficjent");
                                writer.WriteElementString("nazwa_beneficjenta", xlRange.Cells[i, j].Value2.ToString());
                                writer.WriteEndElement();
                                break;
                            case 5:
                                writer.WriteStartElement("fundusz_i_program");
                                writer.WriteElementString("fundusz", xlRange.Cells[i, j].Value2.ToString());
                                break;
                            case 6:
                                writer.WriteElementString("program", xlRange.Cells[i, j].Value2.ToString());
                                break;
                            case 7:
                                writer.WriteElementString("priorytet", xlRange.Cells[i, j].Value2.ToString());
                                break;
                            case 8:
                                writer.WriteElementString("dzialanie", xlRange.Cells[i, j].Value2.ToString());
                                break;
                            case 9:
                                writer.WriteElementString("poddzialanie", xlRange.Cells[i, j].Value2.ToString());
                                writer.WriteEndElement();
                                break;
                            case 10:
                                writer.WriteStartElement("finanse");
                                writer.WriteElementString("wartosc_projektu", xlRange.Cells[i, j].Value2.ToString());
                                break;
                            case 11:
                                writer.WriteElementString("wydatki_kwalifikowalne", xlRange.Cells[i, j].Value2.ToString());
                                break;
                            case 12:
                                writer.WriteElementString("wartosc_unijnego_dofinansowania", xlRange.Cells[i, j].Value2.ToString());
                                break;
                            case 13:
                                writer.WriteElementString("poziom_unijnego_dofinansowania_w_procentach", xlRange.Cells[i, j].Value2.ToString());
                                break;
                            case 14:
                                writer.WriteElementString("forma_finansowania", xlRange.Cells[i, j].Value2.ToString());
                                writer.WriteEndElement();
                                break;
                            case 15:
                                writer.WriteStartElement("miejsce_realizacji_projektu");
                                writer.WriteElementString("miejsce_realizacji_projektu", xlRange.Cells[i, j].Value2.ToString());
                                break;
                            case 16:
                                writer.WriteElementString("typ_obszaru_na_ktorym_realizowany_jest_projekt", xlRange.Cells[i, j].Value2.ToString());
                                writer.WriteEndElement();
                                break;
                            case 17:
                                writer.WriteStartElement("czas_realizacji_projektu");
                                writer.WriteElementString("data_rozpoczecia_realizacji", xlRange.Cells[i, j].Value2.ToString());
                                break;
                            case 18:
                                writer.WriteElementString("data_zakonczenia_realizacji", xlRange.Cells[i, j].Value2.ToString());
                                writer.WriteEndElement();
                                break;
                            case 19:
                                writer.WriteStartElement("informacje_o_projekcie");
                                writer.WriteElementString("projekt_konkursowy_czy_pozakonkursowy", xlRange.Cells[i, j].Value2.ToString());
                                break;
                            case 20:
                                writer.WriteElementString("dziedzina_dzialalnosci_gospodarczej_ktorej_dotyczy_projekt", xlRange.Cells[i, j].Value2.ToString());
                                break;
                            case 21:
                                writer.WriteElementString("obszar_wsparcia_projektu", xlRange.Cells[i, j].Value2.ToString());
                                break;
                            case 22:
                                writer.WriteElementString("cel_projektu", xlRange.Cells[i, j].Value2.ToString());
                                break;
                            case 23:
                                writer.WriteElementString("cel_uzupelniajacy_dla_projektow_EFS_ESF", xlRange.Cells[i, j].Value2.ToString());
                                break;
                            case 24:
                                writer.WriteElementString("projekt_realizowany_w_ramach_terytorialnych_mechanizmow_wdrazania", xlRange.Cells[i, j].Value2.ToString());
                                break;
                            case 25:
                                writer.WriteElementString("finansowanie_zakonczone", xlRange.Cells[i, j].Value2.ToString());
                                writer.WriteEndElement();
                                writer.WriteEndElement();
                                break;                                
                        }
                    }
                }
                writer.Flush();
            }            
        }
    }
}
