using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Reflection;
using System.Xml.Serialization;

namespace Registry
{
    class Program
    {
        static List<Address> addressees = new List<Address>();
        static List<Person> persons = new List<Person>();
        static void Main(string[] args)
        {
            LoadCensusXML();
            //Uncomment basedata() function to load prepared data 
            // basedata();
            bool showMenu = true;
            while (showMenu)
            {
                showMenu = MainMenu();
            }
        }

        private static bool MainMenu()
        {
            Console.Clear();
            Console.WriteLine("Rejestr osób 2020\n");
            Console.WriteLine("Wybierz opcje:");
            Console.WriteLine("1) Wyświetl osoby");
            Console.WriteLine("2) Dodaj osobe");
            Console.WriteLine("3) Zapisz dane do pliku");
            Console.WriteLine("4) Wczytaj dane z pliku");
            Console.WriteLine("0) Exit");
            Console.Write("\r\nWybierz opcje: ");

            switch (Console.ReadLine())
            {
                case "1":
                    Console.Clear();
                    DisplayPeople(0);
                    return true;
                case "2":
                    addBro();
                    return true;
                case "3":
                    SaveCensusXML();
                    return true;
                case "4":
                    LoadCensusXML();
                    return true;
                case "0":
                    Console.WriteLine("Kończymy prace z porgramem..."); ;
                    return false;
                default:
                    return true;
            }
        }
        private static void DisplayPeople(int page)
        {
            Console.Clear();
            if (page < 0) DisplayPeople(0);
            if (page > persons.Count / 10) DisplayPeople(persons.Count / 10);

            int pages = persons.Count / 10 > 1 ? 0 : persons.Count / 10;
            int currentPage = page;

            Console.WriteLine("Rejestr osób 2020\n");
            Console.WriteLine("Strona " + (currentPage + 1) + " z " + (pages + 1));
            if (currentPage == pages)
            {
                for (int j = 1 + (currentPage * 10); j <= persons.Count; j++)
                {
                    Console.WriteLine();
                    Console.Write(j + ") ");
                    persons[j - 1].DisplayDataInLine();
                }
            }

            else
            {
                for (int j = 1 + (currentPage * 10); j <= (currentPage * 10) + 10; j++)
                {
                    Console.WriteLine();
                    Console.Write(j + ") ");
                    persons[j - 1].DisplayDataInLine();
                }
            }
            Console.WriteLine();
            Console.WriteLine("\nn-poprzednia  m-nastepna  w-wyswietl dane  s-szukaj  e-menu");

            switch (Console.ReadLine())
            {
                case "n":
                    DisplayPeople(currentPage - 1);
                    break;
                case "m":
                    DisplayPeople(currentPage + 1);
                    break;
                case "w":
                    DisplayBro();
                    break;
                case "s":
                    SearchBro();
                    break;
                case "e":
                    MainMenu();
                    break;
                default:
                    Console.WriteLine("Wcisnąłeś zły klawisz!");
                    DisplayPeople(currentPage);
                    break;
            }

        }
        private static void DisplayBro()
        {
            Console.WriteLine("\nPodaj numer indexu...");
            string index = Console.ReadLine();
            int iindex = Int32.Parse(index);
            Console.Clear();
            if (iindex > persons.Count || iindex < 1 || persons.Count == 0)
            {
                Console.WriteLine("Brak rekordu..");
                Console.WriteLine("Wcisnij dowolny klawisz by kontynuowac...");
                Console.ReadKey();
                MainMenu();
            }
            persons[iindex - 1].DisplayData();

            {
                Console.WriteLine("Wybierz:");

                Console.Write("\r\n1-usun 2-modyfikuj  3-cofnij ");

                switch (Console.ReadLine())
                {
                    case "1":
                        persons.RemoveAt(iindex - 1);
                        Console.WriteLine("Pomyślnie usunięto rekord");
                        Console.WriteLine("Wcisnij dowolny klawisz by kontynuowac...");
                        Console.ReadKey();
                        break;
                    case "2":
                        modifyMenu(iindex - 1);
                        break;
                    case "3":
                        MainMenu();
                        break;
                    default:
                        MainMenu();
                        break;
                }
            }
        }
        private static void SearchBro()
        {
            Console.WriteLine("Wpisz szukana wartosc: ");
            String searchValue = Console.ReadLine();

            foreach (var item in getMatches(persons, searchValue))
            {
                item.DisplayDataInLine();
            }
            Console.WriteLine("\n\nWcisnij dowolny klawisz by kontynuować... ");
            Console.ReadKey();
        }
        private static void addBro()
        {
            Console.WriteLine("Dodaj osobe do spisu\n");

            String name, surname, birthDate;
            String city, postCode, street, houseNumber, flatNumber;
            Console.WriteLine("Podaj imie");
            name = Console.ReadLine();
            Console.WriteLine("Podaj Nazwisko");
            surname = Console.ReadLine();
            Console.WriteLine("Podaj Date urodzenia (dd-mm-rrrr)");
            birthDate = Console.ReadLine();
            Console.WriteLine("Podaj miejscowosc");
            city = Console.ReadLine();
            Console.WriteLine("Podaj kod pocztowy");
            postCode = Console.ReadLine();
            Console.WriteLine("Podaj ulice");
            street = Console.ReadLine();
            Console.WriteLine("Podaj numer domu");
            houseNumber = Console.ReadLine();
            Console.WriteLine("Podaj numer mieszkania");
            flatNumber = Console.ReadLine();

            persons.Add(new Person
            {
                Name = name,
                Surname = surname,
                BirthDate = birthDate,
                HomeAddress = new Address()
                {
                    City = city,
                    FlatNumber = flatNumber,
                    HouseNumber = houseNumber,
                    PostCode = postCode,
                    Street = street
                }
            });
            MainMenu();
        }

        public static IEnumerable<T> getMatches<T>(List<T> list, string search)
        {
            if (search == null)
                throw new ArgumentNullException("search");
            return list.Select(x => new
            {
                X = x,
                Props = x.GetType().GetProperties(BindingFlags.Instance | BindingFlags.Public),
                Fields = x.GetType().GetFields(BindingFlags.Instance | BindingFlags.Public),
            })
            .Where(x => x.Props.Any(p =>
            {
                var val = p.GetValue(x.X, null);
                return val != null
                && val.GetType().GetMethod("ToString", Type.EmptyTypes).DeclaringType == val.GetType()
                && val.ToString().Contains(search);
            })
                        || x.Fields.Any(p =>
                        {
                            var val = p.GetValue(x.X);
                            return val != null
                            && val.GetType().GetMethod("ToString", Type.EmptyTypes).DeclaringType == val.GetType()
                            && val.ToString().Contains(search);
                        }))
            .Select(x => x.X);
        }

        private static void baseData()
        {
            Address adres0 = new Address()
            {
                City = "Nowy Tomyśl",
                PostCode = "64-300",
                Street = "Jsonowa",
                HouseNumber = "404a",
                FlatNumber = "1b"
            };
            Address adres1 = new Address()
            {
                City = "Bogdanowo",
                PostCode = "61-230",
                Street = "Juniorowa",
                HouseNumber = "5a",
                FlatNumber = "1"
            };
            Address adres2 = new Address()
            {
                City = "Tomkowo",
                PostCode = "62-350",
                Street = "CiSzarp",
                HouseNumber = "15",
                FlatNumber = "1"
            };
            Address adres3 = new Address()
            {
                City = "Dżawa",
                PostCode = "61-300",
                Street = "Andrzeja Nulla",
                HouseNumber = "7",
                FlatNumber = "2"
            };
            Address adres4 = new Address()
            {
                City = "Iława",
                PostCode = "61-300",
                Street = "Słoneczna",
                HouseNumber = "11a",
                FlatNumber = "1"
            };
            Address adres5 = new Address()
            {
                City = "Warszawa",
                PostCode = "52-450",
                Street = "Słoneczna",
                HouseNumber = "155a",
                FlatNumber = "15"
            };
            Address adres6 = new Address()
            {
                City = "Gdynia",
                PostCode = "58-645",
                Street = "Waleczna",
                HouseNumber = "552",
                FlatNumber = "12"
            };
            Address adres7 = new Address()
            {
                City = "Gdańsk",
                PostCode = "61-560",
                Street = "Niebezpieczna",
                HouseNumber = "55ac",
                FlatNumber = "1a"
            };
            Address adres8 = new Address()
            {
                City = "Łóć",
                PostCode = "64-200",
                Street = "Wyznaniowa",
                HouseNumber = "15a",
                FlatNumber = "7"
            };
            Address adres9 = new Address()
            {
                City = "Nowy Targ",
                PostCode = "11-410",
                Street = "Gitarowa",
                HouseNumber = "42",
                FlatNumber = "1a"
            };
            Address adres10 = new Address()
            {
                City = "Zielonka",
                PostCode = "53-330",
                Street = "Fajna",
                HouseNumber = "5a",
                FlatNumber = "1"
            };
            Address adres11 = new Address()
            {
                City = "Krakaw",
                PostCode = "12-110",
                Street = "Słoneczna",
                HouseNumber = "15",
                FlatNumber = "1f"
            };
            Address adres12 = new Address()
            {
                City = "Pobierowo",
                PostCode = "42-340",
                Street = "Słoneczna",
                HouseNumber = "32a",
                FlatNumber = "3"
            };
            Address adres13 = new Address()
            {
                City = "Stefanowo",
                PostCode = "14-500",
                Street = "Fajniutka",
                HouseNumber = "12",
                FlatNumber = "2"
            };

            persons.Add(new Person
            {
                Name = "Json",
                Surname = "son",
                BirthDate = "22-11-1999",
                HomeAddress = adres0
            });
            persons.Add(new Person
            {
                Name = "Adam",
                Surname = "Lewicki",
                BirthDate = "12-12-1959",
                HomeAddress = adres1
            });
            persons.Add(new Person
            {
                Name = "Jarosław",
                Surname = "Zbaw",
                BirthDate = "12-01-1997",
                HomeAddress = adres2
            });
            persons.Add(new Person
            {
                Name = "Adam",
                Surname = "Wiercipieta",
                BirthDate = "15-09-1975",
                HomeAddress = adres3
            });
            persons.Add(new Person
            {
                Name = "Bogdan",
                Surname = "Maciwoda",
                BirthDate = "15-06-1967",
                HomeAddress = adres4
            });
            persons.Add(new Person
            {
                Name = "Rysiu",
                Surname = "Pajton",
                BirthDate = "22-12-1988",
                HomeAddress = adres5
            });
            persons.Add(new Person
            {
                Name = "Bogdan",
                Surname = "Adam",
                BirthDate = "15-02-2004",
                HomeAddress = adres6
            });
            persons.Add(new Person
            {
                Name = "Rafał",
                Surname = "Krecinochal",
                BirthDate = "22-11-2005",
                HomeAddress = adres7
            });
            persons.Add(new Person
            {
                Name = "Eustachy",
                Surname = "Łodyga",
                BirthDate = "15-11-2000",
                HomeAddress = adres8
            });
            persons.Add(new Person
            {
                Name = "Kim",
                Surname = "Kolwiek",
                BirthDate = "22-05-1929",
                HomeAddress = adres9
            });
            persons.Add(new Person
            {
                Name = "Zbyszek",
                Surname = "Walikon",
                BirthDate = "17-06-1974",
                HomeAddress = adres10
            });
            persons.Add(new Person
            {
                Name = "Tomasz",
                Surname = "Comasz",
                BirthDate = "22-05-1951",
                HomeAddress = adres11
            });
            persons.Add(new Person
            {
                Name = "Kamil",
                Surname = "Pieczenoga",
                BirthDate = "05-10-1963",
                HomeAddress = adres12

            });
            persons.Add(new Person
            {
                Name = "Mirosław",
                Surname = "Bolikolano",
                BirthDate = "22-12-1975",
                HomeAddress = adres13

            });

        }

        private static void modifyMenu(int index)
        {
            Console.WriteLine("\n Która wartość chcesz zmodyfikować?");
            Console.WriteLine("1) Imie");
            Console.WriteLine("2) Nazwisko");
            Console.WriteLine("3) Data urodzenia");
            Console.WriteLine("4) Miasto");
            Console.WriteLine("5) Kod pocztowy");
            Console.WriteLine("6) Ulica");
            Console.WriteLine("7) Nr domu");
            Console.WriteLine("8) Nr mieszkania");

            switch (Console.ReadLine())
            {
                case "1":
                    Console.WriteLine("Wprowadz nową wartość");
                    persons[index].Name = Console.ReadLine();
                    Console.WriteLine("Pomyślnie zmodyfikowano rekord");
                    Console.WriteLine("Wcisnij dowolny klawisz by kontynuowac...");
                    Console.ReadKey();
                    break;
                case "2":
                    Console.WriteLine("Wprowadz nową wartość");
                    persons[index].Surname = Console.ReadLine();
                    Console.WriteLine("Pomyślnie zmodyfikowano rekord");
                    Console.WriteLine("Wcisnij dowolny klawisz by kontynuowac...");
                    Console.ReadKey();
                    break;
                case "3":
                    Console.WriteLine("Wprowadz nową wartość");
                    persons[index].BirthDate = Console.ReadLine();
                    Console.WriteLine("Pomyślnie zmodyfikowano rekord");
                    Console.WriteLine("Wcisnij dowolny klawisz by kontynuowac...");
                    Console.ReadKey();
                    break;
                case "4":
                    Console.WriteLine("Wprowadz nową wartość");
                    persons[index].HomeAddress.City = Console.ReadLine();
                    Console.WriteLine("Pomyślnie zmodyfikowano rekord");
                    Console.WriteLine("Wcisnij dowolny klawisz by kontynuowac...");
                    Console.ReadKey();
                    break;
                case "5":
                    Console.WriteLine("Wprowadz nową wartość");
                    persons[index].HomeAddress.PostCode = Console.ReadLine();
                    Console.WriteLine("Pomyślnie zmodyfikowano rekord");
                    Console.WriteLine("Wcisnij dowolny klawisz by kontynuowac...");
                    Console.ReadKey();
                    break;
                case "6":
                    Console.WriteLine("Wprowadz nową wartość");
                    persons[index].HomeAddress.Street = Console.ReadLine();
                    Console.WriteLine("Pomyślnie zmodyfikowano rekord");
                    Console.WriteLine("Wcisnij dowolny klawisz by kontynuowac...");
                    Console.ReadKey();
                    break;
                case "7":
                    Console.WriteLine("Wprowadz nową wartość");
                    persons[index].HomeAddress.HouseNumber = Console.ReadLine();
                    Console.WriteLine("Pomyślnie zmodyfikowano rekord");
                    Console.WriteLine("Wcisnij dowolny klawisz by kontynuowac...");
                    Console.ReadKey();
                    break;
                case "8":
                    Console.WriteLine("Wprowadz nową wartość");
                    persons[index].HomeAddress.FlatNumber = Console.ReadLine();
                    Console.WriteLine("Pomyślnie zmodyfikowano rekord");
                    Console.WriteLine("Wcisnij dowolny klawisz by kontynuowac...");
                    Console.ReadKey();
                    break;

                default:
                    MainMenu();
                    break;
            }
        }

        //Zapisywanie do pliku
        public static void SaveCensusXML()
        {
            try
            {
                using (Stream fs = new FileStream("Cenus.xml",
                                FileMode.Create, FileAccess.Write, FileShare.None))
                {
                    XmlSerializer serializer = new XmlSerializer(typeof(List<Person>));
                    serializer.Serialize(fs, persons);
                    fs.Close();
                }
            }
            catch (Exception e)
            {
                Console.WriteLine(e.Message);
            }
            Console.ReadKey();
        }
        public static void LoadCensusXML()
        {
            try
            {
                XmlSerializer serializer = new XmlSerializer(typeof(List<Person>));
                using (FileStream fs = File.OpenRead("Cenus.xml"))
                {
                    persons = (List<Person>)serializer.Deserialize(fs);
                    fs.Close();
                }
            }
            catch (Exception e)
            {
                Console.WriteLine(e.Message);
            }
        }
    }
}
