public class Answer
{
	public String answerID;
	public String personID;
	public String optionID;
	public int priority;

	public Answer(String answerID, String personID, String optionID, int priority)
	{
		this.answerID = answerID;
		this.personID = personID;
		this.optionID = optionID;
		this.priority = priority;
	}
}
