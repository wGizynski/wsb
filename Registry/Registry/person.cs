using System;

namespace Registry
{
    public class Person : IData
    {
        String name, surname, birthDate;
        Address homeAddress;
        public Person()
        {
            Name = String.Empty;
            Surname = String.Empty;
            BirthDate = String.Empty;
            HomeAddress = null;
        }

        public string Name { get => name; set => name = value; }
        public string Surname { get => surname; set => surname = value; }
        public string BirthDate { get => birthDate; set => birthDate = value; }
        public Address HomeAddress { get => homeAddress; set => homeAddress = value; }
        public void DisplayData()
        {
            Console.WriteLine("Wyświetlan dane osobowe: \n");
            Console.WriteLine("Imię: " + Name);
            Console.WriteLine("Nazwisko: " + Surname);
            Console.WriteLine("Dane Urodzenia: " + BirthDate + "\n");
            HomeAddress.DisplayData();
        }
        public void DisplayDataInLine()
        {
            Console.WriteLine();
            Console.Write("\tImię: " + Name);
            Console.Write("\tNazwisko: " + Surname);
            Console.Write("\t\tDane Urodzenia: " + BirthDate);
        }
    }
}
