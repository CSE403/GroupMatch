import java.util.ArrayList;
import java.util.List;
import java.util.Random;

public class DB
{

	public static List<Person> getPersons(String pollID)
	{
		List<Person> persons = new ArrayList<Person>();
		persons.add(new Person("10", pollID, "Jack"));
		persons.add(new Person("11", pollID, "Brett"));
		persons.add(new Person("12", pollID, "Kyle"));
		persons.add(new Person("13", pollID, "Sean"));
		persons.add(new Person("14", pollID, "Ryan"));
		persons.add(new Person("15", pollID, "Jake"));
		persons.add(new Person("16", pollID, "Eli"));
		persons.add(new Person("17", pollID, "Susie"));
		persons.add(new Person("18", pollID, "Will"));
		persons.add(new Person("19", pollID, "Vic"));
		persons.add(new Person("110", pollID, "Ethan"));
		persons.add(new Person("111", pollID, "Levi"));
		persons.add(new Person("112", pollID, "Matt"));
		persons.add(new Person("113", pollID, "Zach"));
		persons.add(new Person("114", pollID, "Eric"));
		persons.add(new Person("115", pollID, "Nathan"));
		persons.add(new Person("116", pollID, "Jayson"));
		persons.add(new Person("117", pollID, "Rick"));
		persons.add(new Person("118", pollID, "Payton"));
		persons.add(new Person("119", pollID, "Mike"));
		persons.add(new Person("120", pollID, "Jack"));
		persons.add(new Person("121", pollID, "Brett"));
		persons.add(new Person("122", pollID, "Kyle"));
		persons.add(new Person("123", pollID, "Sean"));
		persons.add(new Person("124", pollID, "Ryan"));
		persons.add(new Person("125", pollID, "Jake"));
		persons.add(new Person("126", pollID, "Eli"));
		persons.add(new Person("127", pollID, "Susie"));
		persons.add(new Person("128", pollID, "Will"));
		persons.add(new Person("129", pollID, "Vic"));
		persons.add(new Person("130", pollID, "Ethan"));
		persons.add(new Person("131", pollID, "Levi"));
		persons.add(new Person("132", pollID, "Matt"));
		persons.add(new Person("133", pollID, "Zach"));
		persons.add(new Person("134", pollID, "Eric"));
		persons.add(new Person("135", pollID, "Nathan"));
		persons.add(new Person("136", pollID, "Jayson"));
		persons.add(new Person("137", pollID, "Rick"));
		persons.add(new Person("138", pollID, "Payton"));
		persons.add(new Person("139", pollID, "Mike"));
		return persons;

	}

	public static List<Answer> getAnswers(String personID)
	{
		Random rand = new Random();
		List<Answer> answers = new ArrayList<Answer>();
		answers.add(new Answer(Long.toString(rand.nextLong()), personID, "40",
				rand.nextInt(6)));
		answers.add(new Answer(Long.toString(rand.nextLong()), personID, "41",
				rand.nextInt(6)));
		answers.add(new Answer(Long.toString(rand.nextLong()), personID, "42",
				rand.nextInt(6)));
		answers.add(new Answer(Long.toString(rand.nextLong()), personID, "43",
				rand.nextInt(6)));
		answers.add(new Answer(Long.toString(rand.nextLong()), personID, "44",
				rand.nextInt(6)));
		answers.add(new Answer(Long.toString(rand.nextLong()), personID, "45",
				rand.nextInt(6)));
		answers.add(new Answer(Long.toString(rand.nextLong()), personID, "46",
				rand.nextInt(6)));
		answers.add(new Answer(Long.toString(rand.nextLong()), personID, "47",
				rand.nextInt(6)));
		answers.add(new Answer(Long.toString(rand.nextLong()), personID, "48",
				rand.nextInt(6)));
		answers.add(new Answer(Long.toString(rand.nextLong()), personID, "49",
				rand.nextInt(6)));
		return answers;
	}

	public static List<Option> getOptions(String pollID)
	{
		List<Option> options = new ArrayList<Option>();
		options.add(new Option("40", pollID, "a?", 0));
		options.add(new Option("41", pollID, "b?", 0));
		options.add(new Option("42", pollID, "c?", 0));
		options.add(new Option("43", pollID, "d?", 0));
		options.add(new Option("44", pollID, "e?", 0));
		options.add(new Option("45", pollID, "f?", 0));
		options.add(new Option("46", pollID, "g?", 0));
		options.add(new Option("47", pollID, "h?", 0));
		options.add(new Option("48", pollID, "i?", 0));
		options.add(new Option("49", pollID, "j?", 0));
		return options;
	}

}
