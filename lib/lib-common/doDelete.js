function doDelete()
{
	if (doDelete.arguments.length > 0) {
		txt = '�� �������, ��� ������ �������� ��� ������?';
	} else {
		txt = '�� �������, ��� ������ ������� ��� ������?';
	}
	return confirm(txt);
}
