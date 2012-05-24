import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class PollSolution implements Cloneable
{
	private int maxRating;
	private int totalPeople;
	private int starValue;
	private int numPossiblePeople;
	private int totalOverMax;
	private Map<Option, List<Person>> optionsToPeople;
	private List<Person> peopleNotPlaced;

	public PollSolution(List<Option> options, int numParticipants, int maxRating)
	{
		this.maxRating = maxRating;
		peopleNotPlaced = new ArrayList<Person>();
		numPossiblePeople = 0;
		totalOverMax = 0;
		optionsToPeople = new HashMap<Option, List<Person>>();
		starValue = 0;
		for (Option option : options)
		{
			numPossiblePeople += option.maxSize;
			optionsToPeople.put(option, new ArrayList<Person>());
		}
		totalPeople = numPossiblePeople;
	}

	public PollSolution clone()
	{
		PollSolution toReturn;
		try
		{
			toReturn = (PollSolution) super.clone();
			toReturn.peopleNotPlaced = new ArrayList<Person>(peopleNotPlaced);
			toReturn.optionsToPeople = new HashMap<Option, List<Person>>();
			for (Option option : optionsToPeople.keySet())
			{
				toReturn.optionsToPeople.put(option, new ArrayList<Person>(
						optionsToPeople.get(option)));
			}
		} catch (CloneNotSupportedException e)
		{
			return null;
		}
		return toReturn;
	}

	public boolean hasConflicts()
	{
		return !possibleToMakeValidIn(0);
	}

	public Option findBestOption(Person person)
	{
		Option curBestOption = null;
		for (Option option : optionsToPeople.keySet())
		{
			if (OptionIsValid(option, person)
					&& (curBestOption == null
							|| person.getOptionValue(option) > person
									.getOptionValue(curBestOption) || (person
							.getOptionValue(option) == person
							.getOptionValue(curBestOption) && curBestOption.maxSize
							- optionsToPeople.get(curBestOption).size() > option.maxSize
							- optionsToPeople.get(option).size())))
			{
				curBestOption = option;
			}
		}
		return curBestOption;
	}

	private boolean OptionIsValid(Option option, Person person)
	{
		addPersonToOption(person, option);
		boolean isValid = !hasConflicts();
		removePersonFromOption(person, option);
		return isValid;

	}

	public Map<Option, List<Person>> getSolutionMap()
	{
		Map<Option, List<Person>> toReturn = new HashMap<Option, List<Person>>();
		for (Option option : optionsToPeople.keySet())
		{
			toReturn.put(option,
					new ArrayList<Person>(optionsToPeople.get(option)));
		}
		return toReturn;
	}

	public void addPersonToOption(Person person, Option option)
	{
		if (option == null)
			peopleNotPlaced.add(person);
		else
		{
			optionsToPeople.get(option).add(person);
			starValue += person.getOptionValue(option);
			numPossiblePeople--;
			if (optionsToPeople.get(option).size() > option.maxSize)
				totalOverMax++;
		}
	}

	public void removePersonFromOption(Person person, Option option)
	{
		if (option == null)
			peopleNotPlaced.remove(person);
		else
		{
			optionsToPeople.get(option).remove(person);
			starValue -= person.getOptionValue(option);
			numPossiblePeople++;
			if (optionsToPeople.get(option).size() >= option.maxSize)
				totalOverMax--;
		}
	}
	
	public ArrayList<Person> getPeopleNotPlaced()
	{
		return new ArrayList<Person>(peopleNotPlaced);
	}

	public List<Person> getPeopleForOption(Option option)
	{
		if(option == null)
			return new ArrayList<Person>(peopleNotPlaced);
		return new ArrayList<Person>(optionsToPeople.get(option));
	}

	public int getStarValue()
	{
		return starValue;
	}

	public boolean possibleToMakeValidIn(int depth)
	{
		int totalShifts = totalOverMax;
		if (numPossiblePeople > 0)
		{
			totalShifts += Math.min(numPossiblePeople, peopleNotPlaced.size());
		}
		return totalShifts <= depth;
	}
	
	public int getHappiness(){
		return (starValue*100)/(totalPeople*maxRating);
	}
}
