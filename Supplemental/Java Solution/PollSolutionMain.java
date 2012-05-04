import java.util.List;
import java.util.Map;

public class PollSolutionMain
{
	public static void main(String[] args)
	{
		PollSolution pollSolution = generatePollSolution("20");
		Map<Option, List<Person>> map = pollSolution.getSolutionMap();
		System.out.println("done");
		for (Option option : map.keySet())
		{
			String toPrint = option.name + "\n";
			for (Person person : map.get(option))
			{
				toPrint += "\t" + person.name + " has value of: "
						+ person.getOptionValue(option) + "\n";
			}
			System.out.println(toPrint);
		}
	}

	public static PollSolution generatePollSolution(String pollID)
	{
		List<Person> persons = DB.getPersons(pollID);
		for (Person person : persons)
		{
			person.setAnswers(DB.getAnswers(person.ID));
		}
		List<Option> options = DB.getOptions(pollID);
		PollSolution pollSolution = new PollSolution(options, persons.size());
		Option bestOption;
		for (Person person : persons)
		{
			bestOption = pollSolution.findBestOption(person);
			pollSolution.addPersonToOption(person, bestOption);
		}
		PollSolution curBestSolution = null;
		for (int i = 1; i <= 4; i++)
		{
			curBestSolution = null;
			int j = 0;
			while (curBestSolution == null
					|| curBestSolution.getStarValue() < pollSolution
							.getStarValue())
			{
				curBestSolution = pollSolution.clone();
				pollSolution = move(pollSolution, i, options);
				System.out.println("" + j++ + "@" + System.currentTimeMillis());
			}
			System.out.println("\t" + i + "@" + System.currentTimeMillis());
		}
		return curBestSolution;
	}

	private static PollSolution move(PollSolution pollSolution, int depth,
			List<Option> options)
	{
		PollSolution toReturn = null;
		PollSolution curBest = null;
		if (depth == 0 && !pollSolution.hasConflicts())
			return pollSolution.clone();
		if (depth == 0)
			return toReturn;
		for (Option option : options)
		{
			for (Person person : pollSolution.getPeopleForOption(option))
			{
				pollSolution.removePersonFromOption(person, option);
				for (Option optionAdd : options)
				{
					pollSolution.addPersonToOption(person, optionAdd);
					if (pollSolution.possibleToMakeValidIn(depth - 1))
					{
						curBest = move(pollSolution, depth - 1, options);
						if (toReturn == null
								|| (curBest != null && curBest.getStarValue() > toReturn
										.getStarValue()))
							toReturn = curBest;
					}
					pollSolution.removePersonFromOption(person, optionAdd);
				}
				pollSolution.addPersonToOption(person, option);
			}
		}
		return toReturn;
	}
}
