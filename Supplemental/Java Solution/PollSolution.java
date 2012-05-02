import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class PollSolution implements Cloneable
{

	private int starValue;
	private int maxPerOption;
	private int numRequiredAtLargeSize;
	private int numOptionsAtMax;
	private int totalOverMax;
	private Map<Option, List<Person>> optionsToPeople;

	public PollSolution(List<Option> options, int numParticipants)
	{
		numOptionsAtMax = 0;
		totalOverMax = 0;
		optionsToPeople = new HashMap<Option, List<Person>>();
		starValue = 0;
		numRequiredAtLargeSize = numParticipants % options.size();
		maxPerOption = numParticipants / options.size() + 1;
		for (Option option : options)
			optionsToPeople.put(option, new ArrayList<Person>());
	}

	public PollSolution clone()
	{
		PollSolution toReturn;
		try
		{
			toReturn = (PollSolution) super.clone();
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
			if (curBestOption == null
					|| person.getOptionValue(option) > person
							.getOptionValue(curBestOption)
					|| (person.getOptionValue(option) == person
							.getOptionValue(curBestOption) && optionsToPeople
							.get(curBestOption).size() > optionsToPeople.get(
							option).size()))
			{
				curBestOption = option;
			}
		}
		return curBestOption;
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
		optionsToPeople.get(option).add(person);
		starValue += person.getOptionValue(option);
		if (optionsToPeople.get(option).size() == maxPerOption)
			numOptionsAtMax++;
		else if (optionsToPeople.get(option).size() > maxPerOption)
			totalOverMax++;
	}

	public void removePersonFromOption(Person person, Option option)
	{
		optionsToPeople.get(option).remove(person);
		starValue -= person.getOptionValue(option);
		if (optionsToPeople.get(option).size() == maxPerOption - 1)
			numOptionsAtMax--;
		else if (optionsToPeople.get(option).size() >= maxPerOption)
			totalOverMax--;
	}

	public List<Person> getPeopleForOption(Option option)
	{
		return new ArrayList<Person>(optionsToPeople.get(option));
	}

	public int getStarValue()
	{
		return starValue;
	}

	public boolean possibleToMakeValidIn(int depth)
	{
		int totalShifts = totalOverMax;
		if (numOptionsAtMax > numRequiredAtLargeSize)
		{
			totalShifts += numOptionsAtMax - numRequiredAtLargeSize;
		}
		return totalShifts <= depth;
	}
}
