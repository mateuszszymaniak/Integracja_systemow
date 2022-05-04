using System;
using System.IO;
using System.Xml;
using MySql.Data.MySqlClient;
using System.Linq;

namespace XML_To_DB {
    class Program {
        static void Main(string[] args) {

            string connectionString = "Data Source=localhost;Initial Catalog=systems_integration;User ID=root;Password=";

            MySqlConnection conn = new MySqlConnection(connectionString);

            string path = "C:\\Users\\Mateusz\\Documents\\GitHub\\Integracja_systemow\\XML_Converter\\XML_Converter\\bin\\Debug\\net5.0\\Lista_projektow_FE_2014_2020_030422.xml";
            XmlTextReader reader = new XmlTextReader(path);

            string[] labels = { "tytul_projektu", "skrocony_opis", "numer_umowy", "nazwa_beneficjenta", "fundusz", "program", "priorytet", "dzialanie",
                               "poddzialanie", "wartosc_projektu", "wydatki_kwalifikowalne", "wartosc_unijnego_dofinansowania",
                               "poziom_unijnego_dofinansowania_w_procentach", "forma_finansowania", "miejsce_realizacji_projektu",
                               "typ_obszaru_na_ktorym_realizowany_jest_projekt",
                               "data_rozpoczecia_realizacji", "data_zakonczenia_realizacji", "projekt_konkursowy_czy_pozakonkursowy",
                               "dziedzina_dzialalnosci_gospodarczej_ktorej_dotyczy_projekt", "obszar_wsparcia_projektu", "cel_projektu",
                               "cel_uzupelniajacy_dla_projektow_EFS_ESF", "projekt_realizowany_w_ramach_terytorialnych_mechanizmow_wdrazania",
                               "finansowanie_zakonczone"};
            int counter_labels = 0;
            int ben_array_counter = 0;
            int fund_array_counter = 0;
            int pro_loc_array_counter = 0;
            int dur_array_counter = 0;
            int pro_inf_array_counter = 0;
            int pro_array_counter = 0;
            int fin_array_counter = 0;
            int project_counter = 0;

            string[] pro = new string[3];
            string[] ben = new string[1];
            string[] fund = new string[5];
            string[] fin = new string[5];
            string[] pro_loc = new string[2];
            string[] dur = new string[2];
            string[] pro_inf = new string[7];

            while (reader.Read())
            {
                switch (reader.NodeType)
                {
                    case XmlNodeType.Text:
                        switch (counter_labels)
                        {
                            case 0:
                            case 1:
                            case 2:
                                pro[pro_array_counter] = reader.Value;
                                pro_array_counter++;
                                break;
                            case 3:
                                ben[ben_array_counter] = reader.Value;
                                ben_array_counter++;
                                break;
                            case 4:
                            case 5:
                            case 6:
                            case 7:
                            case 8:
                                fund[fund_array_counter] = reader.Value;
                                fund_array_counter++;
                                break;
                            case 9:
                            case 10:
                            case 11:
                            case 12:
                            case 13:
                                fin[fin_array_counter] = reader.Value;
                                fin_array_counter++;
                                break;
                            case 14:
                            case 15:
                                pro_loc[pro_loc_array_counter] = reader.Value;
                                pro_loc_array_counter++;
                                break;
                            case 16:
                            case 17:
                                dur[dur_array_counter] = reader.Value;
                                dur_array_counter++;
                                break;
                            case 18:
                            case 19:
                            case 20:
                            case 21:
                            case 22:
                            case 23:
                            case 24:
                                pro_inf[pro_inf_array_counter] = reader.Value;
                                pro_inf_array_counter++;
                                break;
                        }
                        counter_labels++;
                        if (counter_labels == labels.Length)
                        {
                            project_counter++;
                            insert_beneficiary(ben, conn);
                            insert_fund(fund, conn);
                            insert_pro_loc(pro_loc, conn);
                            insert_dur(dur, conn);
                            insert_pro_inf(pro_inf, conn);
                            insert_pro(pro, conn, project_counter);
                            insert_fin(fin, conn, project_counter);
                            counters_to_zero(out counter_labels, out ben_array_counter, out fund_array_counter, out pro_loc_array_counter, out dur_array_counter, out pro_inf_array_counter, out pro_array_counter, out fin_array_counter, ben, fund, pro_loc, dur, pro_inf, pro, fin);
                        }
                        break;
                }
            }
        }

        private static void counters_to_zero(out int counter_labels, out int ben_array_counter, out int fund_array_counter, out int pro_loc_array_counter, out int dur_array_counter, out int pro_inf_array_counter, out int pro_array_counter, out int fin_array_counter, string[] ben, string[] fund, string[] pro_loc, string[] dur, string[] pro_inf, string[] pro, string[] fin) {
            counter_labels = 0;
            Array.Clear(pro, 0, pro.Length);
            Array.Clear(ben, 0, ben.Length);
            Array.Clear(fund, 0, fund.Length);
            Array.Clear(fin, 0, fin.Length);
            Array.Clear(pro_loc, 0, pro_loc.Length);
            Array.Clear(dur, 0, dur.Length);
            Array.Clear(pro_inf, 0, pro_inf.Length);
            ben_array_counter = 0;
            fund_array_counter = 0;
            pro_loc_array_counter = 0;
            dur_array_counter = 0;
            pro_inf_array_counter = 0;
            pro_array_counter = 0;
            fin_array_counter = 0;
        }

        public static void insert_beneficiary(string[] ben, MySqlConnection conn) {
            try
            {
                conn.Open();
                string sql = "INSERT INTO beneficiary (name)" +
                    "VALUES (@name)";
                MySqlCommand cmd = new MySqlCommand(sql, conn);
                cmd.Parameters.AddWithValue("@name", ben[0]);
                cmd.ExecuteReader();
                conn.Close();
            }
            catch (Exception ex)
            {
                Console.WriteLine(ex.Message + "\n");
                Console.WriteLine(ex.StackTrace);
            }
        }
        public static void insert_fund(string[] fund, MySqlConnection conn) {
            try
            {
                conn.Open();
                string sql = "INSERT INTO fund_n_programme (fund, programme, priority, measure, submeasure)" +
                    "VALUES (@fund, @programme, @priority, @measure, @submeasure)";
                MySqlCommand cmd = new MySqlCommand(sql, conn);
                cmd.Parameters.AddWithValue("@fund", fund[0]);
                cmd.Parameters.AddWithValue("@programme", fund[1]);
                cmd.Parameters.AddWithValue("@priority", fund[2]);
                cmd.Parameters.AddWithValue("@measure", fund[3]);
                cmd.Parameters.AddWithValue("@submeasure", fund[4]);
                cmd.ExecuteReader();
                conn.Close();
            }
            catch (Exception ex)
            {
                Console.WriteLine(ex.Message + "\n");
                Console.WriteLine(ex.StackTrace);
            }
        }
        public static void insert_pro_loc(string[] pro_loc, MySqlConnection conn) {
            try
            {
                conn.Open();
                string sql = "INSERT INTO project_location (location_place, location_type)" +
                    "VALUES (@location_place, @location_type)";
                MySqlCommand cmd = new MySqlCommand(sql, conn);
                cmd.Parameters.AddWithValue("@location_place", pro_loc[0]);
                cmd.Parameters.AddWithValue("@location_type", pro_loc[1]);
                cmd.ExecuteReader();
                conn.Close();
            }
            catch (Exception ex)
            {
                Console.WriteLine(ex.Message + "\n");
                Console.WriteLine(ex.StackTrace);
            }
        }
        public static void insert_dur(string[] dur, MySqlConnection conn) {
            try
            {
                conn.Open();
                string sql = "INSERT INTO duration (start, end)" +
                    "VALUES (@start, @end)";
                MySqlCommand cmd = new MySqlCommand(sql, conn);
                string ds = dur[0];
                DateTime d1 = DateTime.FromOADate(double.Parse(ds));
                string de = dur[1];
                DateTime d2 = DateTime.FromOADate(double.Parse(de));
                string pattern = "yyyy-MM-dd";

                cmd.Parameters.AddWithValue("@start", d1.ToString(pattern));
                cmd.Parameters.AddWithValue("@end", d2.ToString(pattern));
                cmd.ExecuteReader();
                conn.Close();
            }
            catch (Exception ex)
            {
                Console.WriteLine(ex.Message + "\n");
                Console.WriteLine(ex.StackTrace);
            }
        }
        public static void insert_pro_inf(string[] pro_inf, MySqlConnection conn) {
            try
            {
                conn.Open();
                string sql = "INSERT INTO project_information (competitive_or_not, area_of_economic_activity, area_of_project_intervention, objective, esf_secondary_theme, implemented_under_territorial_delivery_mechanisms, funding_complete)" +
                    "VALUES (@competitive_or_not, @area_of_economic_activity, @area_of_project_intervention, @objective, @esf_secondary_theme, @implemented_under_territorial_delivery_mechanisms, @funding_complete)";
                MySqlCommand cmd = new MySqlCommand(sql, conn);
                cmd.Parameters.AddWithValue("@competitive_or_not", pro_inf[0]);
                cmd.Parameters.AddWithValue("@area_of_economic_activity", pro_inf[1]);
                cmd.Parameters.AddWithValue("@area_of_project_intervention", pro_inf[2]);
                cmd.Parameters.AddWithValue("@objective", pro_inf[3]);
                cmd.Parameters.AddWithValue("@esf_secondary_theme", pro_inf[4]);
                cmd.Parameters.AddWithValue("@implemented_under_territorial_delivery_mechanisms", pro_inf[5]);
                cmd.Parameters.AddWithValue("@funding_complete", pro_inf[6]);
                cmd.ExecuteReader();
                conn.Close();
            }
            catch (Exception ex)
            {
                Console.WriteLine(ex.Message + "\n");
                Console.WriteLine(ex.StackTrace);
            }
        }
        public static void insert_pro(string[] pro, MySqlConnection conn, int project_counter) {
            try
            {
                conn.Open();
                string sql = "INSERT INTO project (title, description, contract_no, beneficiary_idbeneficiary, fund_n_programme_idfund_n_program, project_location_idproject_location, duration_idduration,project_information_idproject_information)" +
                    "VALUES (@title, @description, @contract_no, @beneficiary_idbeneficiary, @fund_n_programme_idfund_n_program, @project_location_idproject_location, @duration_idduration, @project_information_idproject_information)";
                MySqlCommand cmd = new MySqlCommand(sql, conn);

                cmd.Parameters.AddWithValue("@title", pro[0]);
                cmd.Parameters.AddWithValue("@description", pro[1]);
                cmd.Parameters.AddWithValue("@contract_no", pro[2]);
                cmd.Parameters.AddWithValue("@beneficiary_idbeneficiary", project_counter);
                cmd.Parameters.AddWithValue("@fund_n_programme_idfund_n_program", project_counter);
                cmd.Parameters.AddWithValue("@project_location_idproject_location", project_counter);
                cmd.Parameters.AddWithValue("@duration_idduration", project_counter);
                cmd.Parameters.AddWithValue("@project_information_idproject_information", project_counter);
                cmd.ExecuteReader();
                conn.Close();
            }
            catch (Exception ex)
            {
                Console.WriteLine(ex.Message + "\n");
                Console.WriteLine(ex.StackTrace);
            }
        }
        public static void insert_fin(string[] fin, MySqlConnection conn, int project_counter) {
            try
            {
                conn.Open();
                string sql = "INSERT INTO finances (total_value, eligible_expenditure, amount_cofinancing, cofinancing_rate, form, project_idproject)" +
                    "VALUES (@total_value, @eligible_expenditure, @amount_cofinancing, @cofinancing_rate, @form, @project_idproject)";
                MySqlCommand cmd = new MySqlCommand(sql, conn);

                cmd.Parameters.AddWithValue("@total_value", Convert.ToDecimal(fin[0]));
                cmd.Parameters.AddWithValue("@eligible_expenditure", Convert.ToDecimal(fin[1]));
                cmd.Parameters.AddWithValue("@amount_cofinancing", Convert.ToDecimal(fin[2]));
                cmd.Parameters.AddWithValue("@cofinancing_rate", Convert.ToDecimal(fin[3]));
                cmd.Parameters.AddWithValue("@form", fin[4]);
                cmd.Parameters.AddWithValue("@project_idproject", project_counter);
                cmd.ExecuteReader();
                conn.Close();
            }
            catch (Exception ex)
            {
                Console.WriteLine(ex.Message + "\n");
                Console.WriteLine(ex.StackTrace);
            }
        }
    }
}
