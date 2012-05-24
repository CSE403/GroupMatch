import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class Person
{

	public String ID;
	public String pollID;
	public String name;
	private Map<String, Integer> answerValues;

	public Person(String ID, String pollID, String name)
	{
		this.ID = ID;
		this.pollID = pollID;
		this.name = name;
		answerValues = new HashMap<String, Integer>();
	}

	public void setAnswers(List<Answer> answers)
	{
		for (Answer answer : answers)
		{
			answerValues.put(answer.optionID, answer.priority);
		}
	}

	public int getOptionValue(Option option)
	{
		return answerValues.get(option.optionID);
	}

	public boolean equals(Object obj)
	{
		if (obj == null)
			return false;
		if (obj instanceof Person)
		{
			return ID.equals(((Person) obj).ID)
					&& pollID.equals(((Person) obj).pollID)
					&& name.equals(((Person) obj).name)
					&& answerValues.equals(((Person) obj).answerValues);
		}
		return false;
	}

	@Override
	public int hashCode()
	{
		return name.hashCode() * pollID.hashCode() * name.hashCode()
				* (answerValues.hashCode());
	}

}
