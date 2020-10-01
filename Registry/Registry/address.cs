using System;

namespace Registry
{
    public class Address : IData
    {
        string street, city, postCode, houseNumber, flatNumber;
        public Address()
        {
            Street = string.Empty;
            City = string.Empty;
            PostCode = string.Empty;
            HouseNumber = string.Empty;
            FlatNumber = string.Empty;
        }

        public string Street { get => street; set => street = value; }
        public string City { get => city; set => city = value; }
        public string PostCode { get => postCode; set => postCode = value; }
        public string HouseNumber { get => houseNumber; set => houseNumber = value; }
        public string FlatNumber { get => flatNumber; set => flatNumber = value; }

        public void DisplayData()
        {
            Console.WriteLine("Adres zamieszkania: \n");
            Console.WriteLine("Ulica: " + Street + "\nMiasto: " + City + "\nKod pocztowy: " + PostCode + "\nNumer Domu: " + HouseNumber + "\nNumer mieszkania: " + FlatNumber);
        }
        public void DisplayDataInLine()
        {
            Console.Write("\tUlica: " + Street);
            Console.Write("\tCity: " + City);
            Console.Write("\tKod pocztowy: " + PostCode);
            Console.Write("\tNumer Domu: " + HouseNumber);
            Console.Write("\tNumer mieszkania: " + FlatNumber);
        }
    }
}
