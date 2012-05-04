public class Option
{

	public String optionID;
	public String pollID;
	public String name;
	public int maxSize;

	public Option(String optionID, String pollID, String name, int maxSize)
	{
		this.optionID = optionID;
		this.pollID = pollID;
		this.name = name;
		this.maxSize = maxSize;
	}

	@Override
	public boolean equals(Object obj)
	{
		if (obj == null)
			return false;
		if (obj instanceof Option)
		{
			return optionID.equals(((Option) obj).optionID)
					&& pollID.equals(((Option) obj).pollID)
					&& name.equals(((Option) obj).name)
					&& maxSize == ((Option) obj).maxSize;
		}
		return false;
	}

	@Override
	public int hashCode()
	{
		return optionID.hashCode() * pollID.hashCode() * name.hashCode()
				* (maxSize +1);
	}
}
